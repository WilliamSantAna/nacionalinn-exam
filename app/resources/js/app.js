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


const loadPlayers = (campaignId) => {
    fetch(`/campaign/${campaignId}/players`)
    .then(response => response.text())
    .then(html => {
        document.querySelector('.players-campaign').innerHTML = html;
    })
    .catch(error => console.error('Error:', error));
    
};
window.loadPlayers = loadPlayers;

const newCampaignLinkOnClick = () => loadModal('/campaign/new', 'New Campaign', 'modal-md');

const submitCampaignOnClick = () => {
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

const submitPlayerOnClick = () => {
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

const clickPlayer = (elem) => {
    const playerId = elem.getAttribute('data-player-id');
    fetch(`/guild-characters/player/${playerId}`)
        .then(response => response.text())
        .then(html => {
            document.querySelector('.guild-characters').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
};


const delegateClickEvents = (event) => {
    if (event.target) {
        switch (event.target.id) { 
            case 'submitCampaign': return submitCampaignOnClick();
            case 'newCampaignLink': return newCampaignLinkOnClick();
            case 'submitPlayer': return submitPlayerOnClick();
        }

        if (event.target.classList.contains('view-guild')) {
            return clickPlayer(event.target);
        }
    }
};

document.addEventListener('click', delegateClickEvents);

