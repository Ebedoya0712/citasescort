<style>
    /* Force centering of the outer wrapper */
    .profile-photo-centered .fi-fo-field-wrp-label {
        text-align: center;
    }

    /* Center the Field Wrapper itself */
    .profile-photo-centered .fi-fo-field-wrp-body {
        display: flex !important;
        justify-content: center !important;
    }

    /* Target the specific wrapper we added class to */
    .profile-photo-centered .filepond--root {
        width: 250px !important;
        height: 250px !important;
        margin: 0 auto !important;
        /* Explicit centering */
        background-color: transparent !important;
    }

    /* Target the drop label to hide text and show icon */
    .profile-photo-centered .filepond--drop-label {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .profile-photo-centered .filepond--drop-label::after {
        content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='white' class='size-6'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z' /%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z' /%3E%3C/svg%3E") " Mi foto de perfil";
        font-size: 16px;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .profile-photo-centered .filepond--drop-label label {
        display: none !important;
        font-size: 0 !important;
    }

    .profile-photo-centered .filepond--label-action {
        display: none !important;
    }

    /* Ensure the panel background is dark/consistent */
    .profile-photo-centered .filepond--panel-root {
        background-color: #1f2937 !important;
        border: 2px dashed #4b5563 !important;
        border-radius: 50% !important;
        /* Force circle */
    }
</style>