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
            <p><a href="{{ route('leagues.charters.show', [ $league->slug, $current->slug ] ) }}">{{ $current->name }}</a></p>
          @endif

          @if( $upcoming = $league->upcomingCharter( $type->id ) )
            <h4>Upcoming</h4>
            <p><a href="{{ route('leagues.charters.show', [ $league->slug, $upcoming->slug ] ) }}">{{ $upcoming->name }}</a> (becomes active {{ $upcoming->active_from->toDateString() }})</p>
          @endif

          @if( ( $league->historicalCharters( $type->id )->count() ) )
            <h4>Previous</h4>
            <ul>
              @foreach( $league->historicalCharters() as $charter )
                <li><a href="{{ route('leagues.charters.show', [ $league->slug, $charter->slug ] ) }}">{{ $charter->name }}</a></li>
              @endforeach
            </ul>
          @endif
        </div>
