        <div class="tab-pane {{ $key == 0 ? 'active' : '' }}" id="{{ strtolower( $type->name ) }}">
          <h3>{{ $type->name }}</h3>
          @if( $draft = $league->draftCharter( $type->id ) )
            <h4>Draft</h4>
            <p><a href="{{ route('leagues.charters.show', [ $league->slug, $draft->slug ] ) }}">{{ $draft->name }}</a></p>
          @elseif( $pending = $league->pendingCharter( $type->id ) )
            <h4>Pending</h4>
            <p><a href="{{ route('leagues.charters.show', [ $league->slug, $pending->slug ] ) }}">{{ $pending->name }}</a></p>
          @endif

          @if( $current = $league->currentCharter( $type->id ) )
            <h4>Current</h4>
            <p><a href="{{ route('leagues.charters.show', [ $league->slug, $current->slug ] ) }}">{{ $current->name }}</a> (became active <span class="time" title="{{ $current->active_from->toDateString() }}">{{ $current->active_from->diffForHumans() }})</span></p>
          @endif

          @if( $upcoming = $league->upcomingCharter( $type->id ) )
            <h4>Upcoming</h4>
            <p><a href="{{ route('leagues.charters.show', [ $league->slug, $upcoming->slug ] ) }}">{{ $upcoming->name }}</a> (will become active <span class="time" title="{{ $upcoming->active_from->toDateString() }}">{{ $upcoming->active_from->diffForHumans() }})</span></p>
          @endif

          @if( ( $league->historicalCharters( $type->id )->count() ) )
            <h4>Previous</h4>
            <ul>
              @foreach( $league->historicalCharters( $type->id ) as $charter )
                <li><a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a></li>
              @endforeach
            </ul>
          @endif
        </div>
