<div class="mb-3">
    <strong>Characters</strong>
</div>

@foreach ($characters as $character)
    <li class="list-group-item">
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
