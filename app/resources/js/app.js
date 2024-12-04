import './bootstrap';
import 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';

const modalElement = document.getElementById('modal');
const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
const csrf_token = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');
window.activeCampaign = null;
window.activePlayer = null;
window.activeGuild = null;
window.activeCharacter = null;

const autoResizeModal = (size) => {
    const md = document.querySelector('.modal-dialog');
    md.classList.remove('modal-sm');
    md.classList.remove('modal-lg');
    md.classList.remove('modal-xl');
    md.classList.add(size);
};

const loadModal = (url, title, size, callback) => {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.querySelector('.modal-body').innerHTML = html;
            document.querySelector('.modal-title').innerHTML = title;
            modal.show();
            try { callback(); } catch (e) {}
        })
        .catch(error => console.error('Error loading the form:', error));
        autoResizeModal(size);
};
window.loadModal = loadModal;


const loadPlayers = (callback) => {
    fetch(`/campaign/${window.activeCampaign}/players`)
        .then(response => response.text())
        .then(html => {
            document.querySelector('.players-campaign').innerHTML = html;
            try { callback(); } catch (e) {}
        })
        .catch(error => console.error('Error:', error));
    
};
window.loadPlayers = loadPlayers;

const loadCharacters = (callback) => {
    fetch(`/campaign/${window.activeCampaign}/characters-available`)
        .then(response => response.text())
        .then(html => {
            document.querySelector('.characters').innerHTML = html;
            try { callback(); } catch (e) {}
        })
        .catch(error => console.error('Error fetching characters:', error));
};
window.loadCharacters = loadCharacters;

const loadGuildCharacters = (callback) => {
    fetch(`/guild-characters/player/${window.activePlayer}`)
        .then(response => response.text())
        .then(html => {
            document.querySelector('.guild-characters').innerHTML = html;
            try { callback(); } catch (e) {}
        })
        .catch(error => console.error('Error:', error));
};
window.loadGuildCharacters = loadGuildCharacters;

const newCampaignLinkOnClick = (event) => loadModal('/campaign/new', 'New Campaign', 'modal-md');

const submitCampaignOnClick = (event) => {
    const form = document.getElementById('createCampaignForm');
    const formData = new FormData(form);

    const name = formData.get('name');
    if (!name) {
        alert('Campaign Name is required!');
        return;
    }

    fetch('/campaigns', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrf_token()
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            window.activeCampaign = data.campaign.id;
            loadModal(`/players/new/${window.activeCampaign}`, 'Welcome to Campaign ' + data.campaign.name, 'modal-xl', () => {
                loadPlayers();
                loadCharacters();
            });
        }
    })
    .catch(error => console.error('Error:', error));
};

const submitPlayerOnClick = (event) => {
    const form = document.getElementById('createPlayerForm');
    const formData = new FormData(form);

    const name = formData.get('name');
    if (!name) {
        alert('Player Name is required!');
        return;
    }

    fetch('/players', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrf_token()
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            loadPlayers();
            loadCharacters();
        }
    })
    .catch(error => console.error('Error:', error));
};

const clickPlayer = (event) => {
    window.activePlayer = event.target.getAttribute('data-player-id');
    window.activeGuild = event.target.getAttribute('data-guild-id');
    loadGuildCharacters();
};

const balanceTeams = (event) => {
    // Verifica a quantidade de players confirmados
    const confirmedPlayers = document.querySelectorAll('.players-campaign input[type="checkbox"]:checked');

    if (confirmedPlayers.length < 2) {
        alert('It is necessary to have at least 2 confirmed players to distribute the guilds.');
        return; // Interrompe a execução se não houver players suficientes
    }

    fetch(`/distribute-guilds/${window.activeCampaign}`)
        .then(response => response.json())
        .then(data => {
            if (data.guilds) {
                console.log('Guilds distribuídas:', data.guilds);
                //window.activePlayer = data.guilds[0].player.id;
                loadPlayers(() => document.querySelector(`.view-guild[data-player-id="${window.activePlayer}"]`).click());
                loadCharacters();
            }
        })
        .catch(error => {
            if (error.message) {
                alert(error.message);
            }
            console.error('Erro ao distribuir guilds:', error);
        });
};

const addCharacterIntoGuild = () => {
    fetch(`/guild-characters/${window.activeGuild}/add/${window.activeCharacter}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrf_token()
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            loadPlayers(() => document.querySelector(`.view-guild[data-player-id="${window.activePlayer}"]`).click());
            loadCharacters();
        }
    })
    .catch(error => console.error('Error removing character:', error));
};

const addCharacterIntoGuildOnClick = (event) => {
    window.activeCharacter = document.querySelector('.characters .list-group-item.selected').getAttribute('data-character-id');
    addCharacterIntoGuild();
};

const removeCharacterFromGuild = () => {
    fetch(`/guild-characters/${window.activeGuild}/remove/${window.activeCharacter}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrf_token()
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            loadPlayers(() => document.querySelector(`.view-guild[data-player-id="${window.activePlayer}"]`).click());
            loadCharacters();
        }
    })
    .catch(error => console.error('Error removing character:', error));
};

const removeCharacterFromGuildOnClick = (event) => {
    window.activeCharacter = document.querySelector('.guild-characters .list-group-item.selected').getAttribute('data-character-id');
    removeCharacterFromGuild();
};

const clickGuildCharacter = (event) => {
    document.querySelectorAll('.view-guild-character').forEach((elem) => elem.classList.remove('selected'));
    event.target.classList.add('selected');
};

const clickCharacter = (event) => {
    document.querySelectorAll('.view-character').forEach((elem) => elem.classList.remove('selected'));
    event.target.classList.add('selected');
};

const clickConfirmCheckbox = (event) => {
    window.activePlayer = event.target.getAttribute('data-player-id');
    fetch(`/players/${activePlayer}/confirm`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrf_token(),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => null)
    .catch(error => {
        console.error('Erro ao atualizar a confirmação do player:', error);
    });
};

const startGameOnClick = (event) => {
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('start-game-message');
    messageDiv.innerText = 'Starting game...';

    document.body.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.classList.add('fade-out');
        setTimeout(() =>  messageDiv.remove(), 1000);
    }, 3000);
};

const delegateClickEvents = (event) => {
    if (event.target) {
        switch (event.target.id) { 
            case 'submitCampaign': return submitCampaignOnClick(event);
            case 'newCampaignLink': return newCampaignLinkOnClick(event);
            case 'submitPlayer': return submitPlayerOnClick(event);
            case 'balance_teams': return balanceTeams(event);
            case 'addCharacterIntoGuild':  return addCharacterIntoGuildOnClick(event);
            case 'removeCharacterFromGuild': return removeCharacterFromGuildOnClick(event);
            case 'start_game': return startGameOnClick(event);
        }

        if (event.target.classList.contains('view-guild')) return clickPlayer(event);
        if (event.target.classList.contains('view-guild-character')) return clickGuildCharacter(event);
        if (event.target.classList.contains('view-character')) return clickCharacter(event);
        if (event.target.classList.contains('confirm-player')) return clickConfirmCheckbox(event);
    }
};

document.addEventListener('click', delegateClickEvents);

