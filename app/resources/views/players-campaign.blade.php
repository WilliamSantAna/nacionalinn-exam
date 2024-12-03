@foreach ($players as $player)
<ul class="list-group">
    <form id="updatePlayerForm">
        <li class="list-group-item player-item" data-player-id="{{ $player->id }}">
            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
            <input type="hidden" name="player_id" value="{{ $player->id }}">
            <input type="checkbox" class="form-check-input" name="confirmed">
            <strong>{{ $player->name }}</strong>
            <button type="button" class="btn btn-medieval btn-xs float-right view-guild" data-player-id="{{ $player->id }}">Open</button>
        </li>
    </form>
</ul>
@endforeach
