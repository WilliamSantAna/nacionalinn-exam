<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Role Playing Game</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="bg">
            <div class="overlay">
                <div class="rpg-title">Role Playing Game</div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-medieval btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#modal" id="newCampaignLink">
                        <i class="fas fa-crossed-swords"></i>New Campaign
                    </a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content" id="modalContent">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
        
        @vite('resources/js/app.js')
    </body>
</html>