async function processResponse(response, handlerName) {
    try {
        return await response;
    } catch (error) {
        console.error(`Error processing ${handlerName}:`, error.message);
        throw error;
    }
}

export async function setPermission(response) {
    try {
        const data = await processResponse(response, 'Permission');

        switch (data.status) {
            case 'success':
                showToast('Exito', data.message, { timeout: 10000, type: 'success' });
                // setTimeout(function() {
                //     window.location.href = router +'home/end';
                // }, 5000);
                break;


            case 'fileSizeError':
                showToast('Error', data.message, { timeout: 10000, type: 'error' });
                break;

            case 'fileNotAllowed':
                showToast('Error', data.message, { timeout: 10000, type: 'warning' });
                break;

            case 'emptyFile':
                showToast('Error', data.message, { timeout: 10000, type: 'warning' });
                break;

            default:
                showToast('Error', data.message, { timeout: 10000, type: 'error' });
                break;
        }
    } catch (error) {
        console.error('Error al procesar la respuesta:', error.message);
        showToast('Error', 'Error al procesar la respuesta.', { timeout: 5000, type: 'error' });
    }
}
export async function updatePayroll(response) {
    const data = await processResponse(response, 'Permission');
    

    console.log(data.status)
    switch (data.status) {
        case 'success':

            showToast('Exito', data.message, { timeout: 10000, type: 'success' });
            // setTimeout(function() {
            //     window.location.href = router +'dashboard';
            // }, 5000);
            break;

      
            case 'ERROR_PAYROLL_UPDATE_ISR':
                showToast('Error', data.message, { timeout: 10000, type: 'error' });
                document.querySelector('input[name="employee[14][isr]"]').style.border = "3px solid red";
                document.querySelector('input[name="employee[17][isr]"]').style.border = "3px solid red";
                break;

        case 'error':
            showToast('Error', data.message, { timeout: 10000, type: 'error' });
            break;

        default:
            showToast('Error', data.message, { timeout: 10000, type: 'error' });
            break;
    }
}
export async function setNewPayroll(response) {
    const data = await processResponse(response, 'NEW_PAYROLL');
    
    console.log(data.status)
    switch (data.status) {
        case 'success':

            showToast('Exito', data.message, { timeout: 10000, type: 'success' });
            // setTimeout(function() {
            //     window.location.href = router +'dashboard';
            // }, 5000);
            break;

      
            case 'ERROR_PAYROLL_NEW':
                showToast('Error', data.message, { timeout: 10000, type: 'error' });
                break;

        case 'error':
            showToast('Error', data.message, { timeout: 10000, type: 'error' });
            break;

        default:
            showToast('Error', data.message, { timeout: 10000, type: 'error' });
            break;
    }
}
    