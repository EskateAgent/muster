<?php namespace App\Http\Controllers;

use App\League;
use App\Charter;
use App\Skater;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Redirect;

use Illuminate\Http\Request;

class ChartersController extends Controller {

  protected $rules = [
    'name' => ['required', 'min:3'],
    'slug' => ['required'],
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
    $this->validate( $request, $this->rules );

    $charter = Charter::create( array_merge( Input::all(), array('league_id' => $league->id ) ) );

    $charter->replaceSkaters( $this->processFile( $request ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter created');
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
      // mismatch, what are you doing crazyperson?
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
    $this->validate( $request, $this->rules );

    $charter->update( array_except( Input::all(), '_method') );

    $charter->replaceSkaters( $this->processFile( $request ) );

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter updated');
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
    $charter = Charter::whereLeagueId( $league->id )->whereSlug( $charter )->first();

    if( $charter->approved_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has already been approved!');
    }

    if( $charter->approval_requested_at )
    {
      return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'You have already requested approval for this charter!');
    }

    $charter->approval_requested_at = date('c');
    $charter->save();

    return Redirect::route('leagues.charters.show', [ $league->slug, $charter->slug ] )->with('message', 'Charter has been submitted for approval');
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
