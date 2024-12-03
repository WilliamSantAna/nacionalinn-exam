<div class="mb-3">
    <strong>{{ $player->guild->name }} - XP: {{ $player->guild->xp }}</strong>
</div>

@foreach ($characters as $character)
    <li class="list-group-item view-guild-character" data-player-id="{{ $player->id }}" data-guild-id="{{ $character->pivot->guild_id }}" data-character-id="{{ $character->pivot->character_id }}">
        <img src="img/characters/{{ strtolower($character->archetype) }}-{{ strtolower($character->name) }}.jpeg" />
        
        <div class="description">
            <strong>{{ $character->name }}</strong>
            <strong>{{ $character->xp }}</strong>
        </div>

        <div class="attributes">
            <strong>{{ $character->archetype }}</strong>
            <strong>HP: {{ $character->hp }}</strong>
            <strong>AT: {{ $character->at }}</strong>
            <strong>DF: {{ $character->df }}</strong>
            <strong>QA: {{ $character->qa }}</strong>
            <strong>IN: {{ $character->in }}</strong>
        </div>
    </li>
@endforeach