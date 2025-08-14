<!--== #HEADER ==-->
<?php adminHeader($data); ?>
<div class="app-form">
    <form class="form-data " data-destination="auth" calling-method="setLogin" data-type="json">

        <div class="form-header">
            <div class="title">
                <h3>NSF</h3>
            </div>
            <div class="description">
                <p>Datos NSF</p>
            </div>
        </div>
        <div class="form-body">
            <div class="form-grid column-1">
                <div class="form-box label">
                    <label class="label-input" for="clientStatus">Estado</label>
                    <input class="control-box small" type="text" name="clientStatus" id="clientStatus" placeholder="Estado">
                </div>
                <div class="form-box label">
                    <label class="label-input" for="dateProgramming">Para cuando reprogramo el cliente?</label>
                    <input class="control-box small" type="date" name="dateProgramming" id="dateProgramming">
                </div>
                <div class="form-box label">
                    <label class="label-input" for="clientName">Nombre completo</label>
                    <input class="control-box small" type="text" name="clientName" id="clientName" placeholder="Nombre del cliente">
                </div>
                <div class="form-box label">
                    <label class="label-input" for="clientPhone">Teléfono</label>
                    <input class="control-box small" type="text" name="clientPhone" id="clientPhone" placeholder="Teléfono del cliente">
                </div>
                <div class="form-box label">
                    <label class="label-input" for="clientEmail">Correo electrónico</label>
                    <input class="control-box small" type="text" name="clientEmail" id="clientEmail" placeholder="Teléfono del cliente">
                </div>
                <div class="form-box label">
                    <label for="financialAdvisor">Asesor financiero</label>
                    <select class="control-box small" name="financialAdvisor" id="financialAdvisor">
                        <option disabled="" selected="">Option</option>
                        <option value="hfg">Samael Varela</option>
                        <option value="dmb">Amalia Suarez</option>
                    </select>
                </div>
                <div class="form-box label">
                    <label for="clientProgram">Programa</label>
                    <select class="control-box small" name="clientProgram" id="clientProgram">
                        <option disabled="" selected="">Option</option>
                        <option value="hfg">HFG</option>
                        <option value="dmb">DMB</option>
                    </select>
                </div>

                <div class="form-box label">
                    <label for="clientNote">Nota</label>
                    <textarea class="control-box" name="clientNote" id="clientNote" placeholder="Nota adicioonal"></textarea>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="buttons">
                <button id="save-form" class="button button-primary big-button">Guardar</button>
            </div>
        </div>
    </form>
</div>
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>