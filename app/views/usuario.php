<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Usuario y Contraseña</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <form id="form_usuario" class="border p-4">
                                    <h2 class="h4">Cambiar usuario</h2>
                                    <div class="row ">
                                        <div class="col-12 form-group">
                                            <label for="usuario">Usuario</label>
                                            <input type="text" class="form-control" value="<?=isset($usuario)?$usuario:''?>" id="usuario">
                                        </div>
                                        <div class="col-12 form-group">
                                            <input type="submit" value="Cambiar" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <form id="form_usuario" class="border p-4">
                                    <h2 class="h4">Cambiar contraseña</h2>
                                    <div class="row ">
                                        <div class="col-12 form-group">
                                            <label for="antigua">Contraseña Antigua</label>
                                            <input type="password" class="form-control" id="antigua">
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="nueva">Contraseña nueva</label>
                                            <input type="password" class="form-control" id="nueva">
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="validar_nueva">Validar contraseña</label>
                                            <input type="password" class="form-control" id="validar_nueva">
                                        </div>
                                        <div class="col-12 form-group">
                                            <input type="submit" value="Cambiar" class="btn btn-success">
                                        </div>
                                    </div>
                                </form> 
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
