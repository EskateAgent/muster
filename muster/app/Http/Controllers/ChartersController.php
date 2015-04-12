<?php namespace App\Http\Controllers;

use App\League;
use App\Charter;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Input;
use Redirect;

use Illuminate\Http\Request;
use App\Commands\LogEventCommand;

class ChartersController extends Controller {

  protected $rules = [
    'name' => ['required', 'min:3'],
    'csv'  => ['required'],
  ];

  /**
   * Display a listing of the resource.
   *
   * @param  League $league
   * @return Response
   */
  public function index( League $league )
  {
    return view('charters.index', compact('league') );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @param  League $league
   * @param  Request $request
   * @return Response
   */
  public function create( League $league )
  {
    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      \App::abort(403);
    }

    return view('charters.create', compact('league') );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  League $league
   * @return Response
   */
  public function store( League $league, Request $request )
  {
    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      \App::abort(403);
    }

    $this->validate( $request, $this->rules );

    $charter = Charter::create( array_merge( Input::all(), array('league_id' => $league->id ) ) );

    $charter->replaceSkaters( $this->processFile( $request ) );

    $this->dispatch( new LogEventCommand( Auth::user(), 'stored', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has been created');
  }

  /**
   * Display the specified resource.
   *
   * @param  League $league
   * @param  Charter $charter
   * @return Response
   */
  public function show( League $league, Charter $charter )
  {
    if( $charter->league != $league )
    {
      return Redirect::route('leagues.show', $league->slug )->with('message', 'Charter not found!');
    }

    if( !( ( $league->currentCharter() && ( $league->currentCharter()->id == $charter->id ) ) || ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('staff') || Auth::user()->hasRole('root') ) )
    {
      \App::abort(403);
    }

    return view('charters.show', compact('league', 'charter') );
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  League $league
   * @param  Charter $charter
   * @return Response
   */
  public function edit( League $league, Charter $charter )
  {
    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      \App::abort(403);
    }

    return view('charters.edit', compact('league', 'charter') );
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  League $league
   * @param  Charter $charter
   * @param  Request $request
   * @return Response
   */
  public function update( League $league, Charter $charter, Request $request )
  {
    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      \App::abort(403);
    }

    $this->validate( $request, $this->rules );

    $charter->update( array_except( Input::all(), '_method') );

    $charter->replaceSkaters( $this->processFile( $request ) );

    $this->dispatch( new LogEventCommand( Auth::user(), 'updated', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has been updated');
  }

  /**
   * Request that the charter be approved
   *
   * @param  string $league
   * @param  string $charter
   * @return Response
   */
  public function requestApproval( $league, $charter )
  {
    $league = League::whereSlug( $league )->first();
    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      \App::abort(403);
    }

    $charter = Charter::whereLeagueId( $league->id )->whereSlug( $charter )->first();

    if( $charter->approved_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has already been approved!');
    }

    if( $charter->approval_requested_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'You have already requested approval for this charter!');
    }

    $charter->approval_requested_at = \Carbon\Carbon::now();
    $charter->save();

    $user = Auth::user();
    $charter_url = env('APP_URL') . '/leagues/' . $league->slug . '/charters/' . $charter->slug;
    \Mail::send('emails.charter_submitted', ['name' => $user->name, 'charter' => $charter, 'charter_url' => $charter_url ], function( $message )use( $user ){
      $message->to( $user->email, $user->name )->subject('Charter Submitted for Approval');
    });
    \Mail::send('emails.charter_submitted', ['name' => env('MAIL_FROM_NAME'), 'charter' => $charter, 'charter_url' => $charter_url ], function( $message ){
      $message->to( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME') )->subject('Charter Submitted for Approval');
    });

    $this->dispatch( new LogEventCommand( Auth::user(), 'requested-approval', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has been submitted for approval');
  }

  /**
   * Approve the charter
   *
   * @param  string $league
   * @param  string $charter
   * @return Response
   */
  public function approve( $league, $charter )
  {
    $league = League::whereSlug( $league )->first();
    $charter = Charter::whereLeagueId( $league->id )->whereSlug( $charter )->first();

    if( $charter->approved_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has already been approved!');
    }

    if( !$charter->approval_requested_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has not been submitted for approval!');
    }

    $charter->update( array_except( Input::all(), '_method') );
    $charter->approved_at = \Carbon\Carbon::now();
    $charter->save();

    $this->dispatch( new LogEventCommand( Auth::user(), 'approved', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has been approved');
  }

  /**
   * Reject the charter
   *
   * @param  string $league
   * @param  string $charter
   * @return Response
   */
  public function reject( $league, $charter )
  {
    $league = League::whereSlug( $league )->first();
    $charter = Charter::whereLeagueId( $league->id )->whereSlug( $charter )->first();

    if( $charter->approved_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has already been approved!');
    }

    if( !$charter->approval_requested_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has not been submitted for approval!');
    }

    $charter->update( array_except( Input::all(), '_method') );
    $charter->approval_requested_at = null;
    $charter->save();

    $this->dispatch( new LogEventCommand( Auth::user(), 'rejected', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has been rejected!');
  }

  /**
   * Process the file upload into an array of skater records to save
   *
   * @param  Request $request
   * @return array
   */
  protected function processFile( Request $request )
  {
    $skaters = array();
    if( $request->hasFile('csv') && $request->file('csv')->isValid() )
    {
      $file = $request->file('csv')->openFile();
      $headers = array();
      $name_index = $number_index = null;
      $i = 0;
      while( $row = $file->fgetcsv() )
      {
        if( $i > 30 )
        {
          break;
        }

        if( count( $row ) > 3 )
        {
          if( !$headers )
          {
            $headers = $row;
            $name_index = array_search('derby_name', $headers );
            $number_index = array_search('uniform_nbr', $headers );
            continue;
          }

          $skaters[] = array('name' => $row[ $name_index ], 'number' => $row[ $number_index ] );
        }
        $i++;
      }
    }
    return $skaters;
  }
}
