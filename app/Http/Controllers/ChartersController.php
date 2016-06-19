<?php namespace App\Http\Controllers;

use App\League;
use App\Charter;
use App\CharterType;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Input;
use Redirect;

use Illuminate\Http\Request;
use App\Commands\LogEventCommand;

class ChartersController extends Controller {

  protected $rules = [
    'charter_type_id' => ['required'],
    'csv'             => ['required'],
  ];

  /**
   * Show the form for creating a new resource.
   *
   * @param  League $league
   * @param  Request $request
   * @return Response
   */
  public function create( $league )
  {
    $league = League::where('slug', $league )->first();

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      return Redirect::route('leagues.index')->with('error', 'You cannot create a charter for this league.');
    }

    return view('charters.create', compact('league') );
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  League $league
   * @return Response
   */
  public function store( $league, Request $request )
  {
    $league = League::where('slug', $league )->first();

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      return Redirect::route('leagues.index')->with('error', 'You cannot create a charter for this league.');
    }

    $this->validate( $request, $this->rules );

    $charter = Charter::create( ['league_id' => $league->id ] + array_merge(['name' => $league->generateNextCharterName() ], Input::all() ) );

    try
    {
      $charter->replace( $this->processFile( $request ) );
    }
    catch( Exception $e )
    {
      return Redirect::route('leagues.show', [ $league->slug ] )->with('error', $e->getMessage() );
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'stored', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has been created');
  }

  /**
   * Display the specified resource.
   *
   * @param  League $league
   * @param  Charter $charter
   * @return Response
   */
  public function show( $league, $charter )
  {
    $league = League::withTrashed()->where('slug', $league )->first();

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( $league->isDeleted() )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'League has been deleted, charters can no longer be viewed.');
    }

    $charter = Charter::withTrashed()->where('slug', $charter )->where('league_id', $league->id )->first();

    if( ( $charter->isDeleted() && !Auth::user()->can('charter-delete') ) || !( ( $league->currentCharter() && ( $league->currentCharter()->id == $charter->id ) ) || ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('staff') || Auth::user()->hasRole('root') ) )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'Charter could not be found.');
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
  public function edit( $league, $charter )
  {
    $league = League::where('slug', $league )->first();

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( $league->isDeleted() )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'League has been deleted, charters can no longer be edited.');
    }

    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'You cannot edit this charter.');
    }

    $charter = Charter::where('slug', $charter )->where('league_id', $league->id )->first();

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
  public function update( $league, $charter, Request $request )
  {
    $league = League::where('slug', $league )->first();

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( $league->isDeleted() )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'League has been deleted, charters can no longer be edited.');
    }

    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'You cannot edit this charter.');
    }

    $charter = Charter::where('slug', $charter )->where('league_id', $league->id )->first();

    $this->validate( $request, $this->rules );

    $charter->update( array_except( Input::all(), '_method') );

    try
    {
      $charter->replace( $this->processFile( $request ) );
    }
    catch( Exception $e )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('error', $e->getMessage() );
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'updated', $charter ) );
    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has been updated');
  }

  /**
   * Soft delete the specified resource from storage.
   *
   * @param  League $league
   * @param  Charter $charter
   * @return Response
   */
  public function delete( $league, $charter )
  {
    $league = League::where('slug', $league )->first();

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( $league->isDeleted() )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'League has been deleted, charters can no longer be deleted.');
    }

    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'You cannot delete this charter.');
    }

    $charter = Charter::where('slug', $charter )->where('league_id', $league->id )->first();

    if( ( $charter->isDeleted() || $charter->approval_requested_at ) && !Auth::user()->hasRole('root') )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'You cannot delete this charter.');
    }

    $charter->delete();
    $this->dispatch( new LogEventCommand( Auth::user(), 'deleted', $charter ) );

    return Redirect::route('leagues.show', [ $league->slug ] )->with('message', 'Charter ' . $charter->name . ' has been deleted');
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

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( $league->isDeleted() )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'League has been deleted, you can no longer request approval for charters.');
    }

    if( !( ( Auth::user()->id == $league->user_id ) || Auth::user()->hasRole('root') ) )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'You cannot request approval for this charter.');
    }

    $charter = Charter::whereLeagueId( $league->id )->whereSlug( $charter )->first();

    if( $charter->approved_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has already been approved!');
    }

    if( $charter->approval_requested_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'You have already requested approval for charter ' . $charter->name . '!');
    }

    $charter->approval_requested_at = \Carbon\Carbon::now();
    $charter->save();

    $user = Auth::user();
    \Mail::send('emails.charter_submitted', ['name' => $user->name, 'charter' => $charter ], function( $message )use( $user, $charter ){
      $message->to( $user->email, $user->name )->subject('Charter ' . $charter->name . ' Submitted for Approval');
    });
    \Mail::send('emails.charter_submitted', ['name' => env('MAIL_FROM_NAME'), 'charter' => $charter ], function( $message )use( $charter ){
      $message->to( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME') )->subject('Charter ' . $charter->name . ' Submitted for Approval');
    });

    $this->dispatch( new LogEventCommand( Auth::user(), 'requested-approval', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has been submitted for approval');
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

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( $league->isDeleted() )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'League has been deleted, charters can no longer be approved.');
    }

    $charter = Charter::whereLeagueId( $league->id )->whereSlug( $charter )->first();

    if( $charter->approved_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has already been approved!');
    }

    if( !$charter->approval_requested_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has not been submitted for approval!');
    }

    $charter->update( array_except( Input::all(), '_method') );
    $charter->approved_at = \Carbon\Carbon::now();
    $charter->save();

    if( $league->user_id )
    {
      $user = $league->user;
      \Mail::send('emails.charter_approved', ['name' => $user->name, 'charter' => $charter ], function( $message )use( $user, $charter ){
        $message->to( $user->email, $user->name )->subject('Charter ' . $charter->name . ' Approved');
      });
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'approved', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has been approved');
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

    if( !$league )
    {
      return Redirect::route('leagues.index')->with('error', 'League could not be found.');
    }

    if( $league->isDeleted() )
    {
      return Redirect::route('leagues.show', $league->slug )->with('error', 'League has been deleted, charters can no longer be rejected.');
    }

    $charter = Charter::whereLeagueId( $league->id )->whereSlug( $charter )->first();

    if( $charter->approved_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has already been approved!');
    }

    if( !$charter->approval_requested_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has not been submitted for approval!');
    }

    $input = array_except( Input::all(), '_method');
    if( !( isset( $input['rejection_reason'] ) && $input['rejection_reason'] ) )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('error', 'You must provide a reason to reject charter ' . $charter->name . '!');
    }

    $charter->update( $input );
    $charter->approval_requested_at = null;
    $charter->save();

    if( $league->user_id )
    {
      $user = $league->user;
      \Mail::send('emails.charter_rejected', ['name' => $user->name, 'charter' => $charter ], function( $message )use( $user, $charter ){
        $message->to( $user->email, $user->name )->subject('Charter ' . $charter->name . ' Could Not Be Approved');
      });
    }

    $this->dispatch( new LogEventCommand( Auth::user(), 'rejected', $charter ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter ' . $charter->name . ' has been rejected!');
  }

  /**
   * Process the file upload into an array of skater records to save
   *
   * @param  Request $request
   * @return array
   */
  protected function processFile( Request $request )
  {
    $content = [
      'name'           => null,
      'effective_from' => null,
      'skaters'        => []
    ];

    if( $request->hasFile('csv') && $request->file('csv')->isValid() )
    {
      $file = $request->file('csv')->openFile();
      $name_index = $number_index = null;

      $file->rewind();
      $i = 0;
      while( $row = $file->fgetcsv() )
      {
        $i++;

        $count = count( $row );

        if( !$count )
        {
          continue;
        }

        if( $count < 3 )
        {
          if( is_null( $content['name'] ) && ( $row[0] == 'roster_id') && isset( $row[1] ) && $row[1] )
          {
            $content['name'] = trim( $row[1] );
          }
          elseif( is_null( $content['effective_from'] ) && ( $row[0] == 'effective_date') && isset( $row[1] ) && $row[1] )
          {
            $content['effective_from'] = trim( $row[1] );
          }
          continue;
        }

        if( ( $i > 50 ) || ( count( $content['skaters'] ) > 20 ) )
        {
          throw new Exception('Looks like something went funny with your file. Please download a new copy of the template and try again.');
        }

        if( !isset( $name_index, $number_index ) )
        {
          if( ( array_search('uniform_nbr', $row ) !== false ) && ( array_search('derby_name', $row ) !== false ) && ( array_search('legal_name', $row ) !== false ) )
          {
            $name_index = array_search('derby_name', $row );
            $number_index = array_search('uniform_nbr', $row );
            $legal_name_index = array_search('legal_name', $row );
          }
          continue;
        }

        $content['skaters'][] = ['name' => $row[ $name_index ], 'legal_name' => $row[ $legal_name_index ], 'number' => $row[ $number_index ] ];
      }
    }

    return $content;
  }
}
