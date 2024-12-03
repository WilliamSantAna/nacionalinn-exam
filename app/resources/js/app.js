import './bootstrap';
import 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';

const modalElement = document.getElementById('modal');
const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
const csrf_token = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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


const loadPlayers = (campaignId, callback) => {
    fetch(`/campaign/${campaignId}/players`)
    .then(response => response.text())
    .then(html => {
        document.querySelector('.players-campaign').innerHTML = html;
        try { callback(); } catch (e) {}
    })
    .catch(error => console.error('Error:', error));
    
};
window.loadPlayers = loadPlayers;

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
            loadModal(`/players/new/${data.campaign.id}`, 'Welcome to Campaign ' + data.campaign.name, 'modal-xl', () => {
                window.loadPlayers(data.campaign.id);
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
            loadPlayers(data.player.campaign_id);
        }
    })
    .catch(error => console.error('Error:', error));
};

const clickPlayer = (event) => {
    const playerId = event.target.getAttribute('data-player-id');
    fetch(`/guild-characters/player/${playerId}`)
        .then(response => response.text())
        .then(html => {
            document.querySelector('.guild-characters').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
};

const balanceTeams = (event) => {
    const campaignId = event.target.getAttribute('data-campaign-id');
    fetch(`/distribute-guilds/${campaignId}`)
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
            }
            if (data.guilds) {
                console.log('Guilds distribuídas:', data.guilds);
                const player = data.guilds[0].player;
                loadPlayers(player.campaign_id, () => {
                    document.querySelector(`.view-guild[data-player-id="${player.id}"]`).click();                    
                });
            }
        })
        .catch(error => {
            console.error('Erro ao distribuir guilds:', error);
        });
};


const delegateClickEvents = (event) => {
    if (event.target) {
        switch (event.target.id) { 
            case 'submitCampaign': return submitCampaignOnClick(event);
            case 'newCampaignLink': return newCampaignLinkOnClick(event);
            case 'submitPlayer': return submitPlayerOnClick(event);
            case 'balance_teams': return balanceTeams(event);
        }

        if (event.target.classList.contains('view-guild')) {
            return clickPlayer(event);
        }
    }
};

document.addEventListener('click', delegateClickEvents);

