

    <div class="player-container mb-3">
        <div class="left-content">
            <div class="mb-3">
                <strong>Players in campaign</strong>
            </div>

            <form id="createPlayerForm">
                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" required placeholder="Enter Player Name">
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-medieval btn-sm w-100" id="submitPlayer">Create Player</button>
                </div>
            </form>

            <div class="mb-3 players-list">
                <div class="players-campaign">
                </div>
            </div>

        </div>
        <div class="right-content">
            <div class="guild">
                <div class="guild-characters">
                </div>
            </div>

            <div class="add-remove">
                <input type="button" class="btn btn-medieval" value="<<">
                <input type="button" class="btn btn-medieval" value=">>">
            </div>


            <div class="characters">
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

            </div>

        </div>

    </div>

    <div class="players-footer">
        <input type="button" class="btn btn-sm btn-medieval" value="Redistribute">
        <input type="button" class="btn btn-start-game" value="Start Game">
    </div>


</form>