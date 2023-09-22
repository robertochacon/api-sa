
<div style="margin:auto;width:500px;">

    <div style="width:100%;display:flex;justify-content: center;padding-top:20px;text-align: center;">
        <!-- <img src="https://assistant.snackpickrd.com/assets/img/logo.png" width="150px" alt="description of myimage"> -->
        <img src="{{ URL('assets/img/logo.png') }}" width="150px" alt="description of myimage">
    </div>
    <hr>
    <h1 style="color:#fd3232;">¡Felicidades!</h1>
    <h3>Ya eres parte de nuestra plataforma de servicios snackpick assistant.</h3>
    <h3>Tu negocio <b>{{ $entity->name ?? '' }}</b> ya esta listo para el siguiente paso.</h3>
    <a href="https://assistant.snackpickrd.com/#/login">Para acceder has click en este enlace</a>
    <hr>
    <div style="width:100%;display:flex;justify-content: center;">
        <h3 style="width:100%;padding:50px;background:black;color:white;text-align: center;">Gracias por preferirnos</h3>
    </div>

</div>