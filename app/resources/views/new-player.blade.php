<div class="player-container mb-3">
    <div class="left-content">
        <div class="mb-3">
            <strong>Players in campaign</strong>
        </div>

        <form id="createPlayerForm">
            <input type="hidden" id="campaign_id" name="campaign_id" value="{{ $campaign->id }}">
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
            <input type="button" id="addCharacterIntoGuild" class="btn btn-medieval" value="<<">
            <input type="button" id="removeCharacterFromGuild" class="btn btn-medieval" value=">>">
        </div>

        <div class="characters">
        </div>
    </div>

</div>

<div class="players-footer">
    <input type="button" class="btn btn-medieval" id="balance_teams" value="Balance    Teams" data-campaign-id="{{ $campaign->id }}">
    <input type="button" class="btn btn-start-game" id="start_game" value="Start    Game" data-campaign-id="{{ $campaign->id }}">
</div>