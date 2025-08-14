async function processResponse(response, handlerName) {
    try {
        return await response;
    } catch (error) {
        console.error(`Error processing ${handlerName}:`, error.message);
        throw error;
    }
}

export async function updatePermissions(response) {
    const data = await processResponse(response, 'Permissions');
    console.log(data.status)
    switch (data.status) {
        case 'success':

            showToast('Exito', data.message, { timeout: 10000, type: 'success' });
            setTimeout(function() {
                window.location.href = router +'dashboard';
            }, 5000);
            break;

        case 'error':
            showToast('Error', data.message, { timeout: 10000, type: 'error' });
            break;

        default:
            showToast('Error', data.message, { timeout: 10000, type: 'error' });
            break;
    }
}