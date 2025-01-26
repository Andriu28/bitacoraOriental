document.addEventListener('DOMContentLoaded', function() {
    const cbxEstado = document.getElementById('estado');
    const cbxMunicipio = document.getElementById('municipio');
    const cbxParroquia = document.getElementById('parroquia');

    if (cbxEstado) {
        cbxEstado.addEventListener('change', getMunicipios);
    }

    if (cbxMunicipio) {
        cbxMunicipio.addEventListener('change', getParroquias);
    }

    function fetchAdnSetData(url, formData, targetElement) {
        return fetch(url, {
            method: "post",
            body: formData,
            mode: 'cors'
        })
        .then(response => response.json())
        .then(data => {
            targetElement.innerHTML = data;
        })
        .catch(err => console.log(err));
    }

    function getMunicipios() {
        if (cbxEstado && cbxMunicipio && cbxParroquia) {
            let estado = cbxEstado.value;
            let url = 'model/address.php';
            let formData = new FormData();
            formData.append('id_e', estado);

            // Limpiar municipios y parroquias
            cbxMunicipio.innerHTML = "<option value=''>Seleccionar</option>";
            cbxParroquia.innerHTML = "<option value=''>Seleccionar</option>";

            fetchAdnSetData(url, formData, cbxMunicipio)
            .catch(err => console.log(err));
        }
    }

    function getParroquias() {
        if (cbxMunicipio && cbxParroquia) {
            let municipio = cbxMunicipio.value;
            let url = 'model/address.php';
            let formData = new FormData();
            formData.append('id_m', municipio);

            // Limpiar parroquias
            cbxParroquia.innerHTML = "<option value=''>Seleccionar</option>";

            fetchAdnSetData(url, formData, cbxParroquia)
            .catch(err => console.log(err));
        }
    }
});
