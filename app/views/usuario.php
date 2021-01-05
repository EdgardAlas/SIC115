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
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12">
                                        <form id="form_correo" class="border p-4">
                                            <h2 class="h4">Cambiar correo</h2>
                                            <div class="row ">
                                                <div class="col-12 form-group">
                                                    <label for="correo">Correo</label>
                                                    <input type="text" class="form-control" value="<?=isset($correo)?$correo:''?>" id="correo" data-ok="0">
                                                </div>
                                                <div class="col-12 form-group">
                                                    <button type="submit" class="btn btn-success btn-block" id="submit_correo">
                                                        <i class="fas fa-save"></i>
                                                        Cambiar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="w-100">

                                    &nbsp;
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <form id="form_usuario" class="border p-4">
                                            <h2 class="h4">Cambiar usuario</h2>
                                            <div class="row ">
                                                <div class="col-12 form-group">
                                                    <label for="usuario">Usuario</label>
                                                    <input type="text" class="form-control" value="<?=isset($usuario)?$usuario:''?>" id="usuario" data-ok="0">
                                                </div>
                                                <div class="col-12 form-group">
                                                    <button type="submit" class="btn btn-success btn-block" id="submit_usuario">
                                                        <i class="fas fa-save"></i>
                                                        Cambiar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 d-md-none d-block">
                                &nbsp;
                            </div>
                            <div class="col-12 col-md-6">
                                <form id="form_contasena" class="border p-4 position-relative">
                                    <h2 class="h4">Cambiar contraseña</h2>
                                    <div class="row ">
                                        <div class="col-12 form-group">
                                            <label for="antigua">Contraseña Antigua</label>
                                            <input type="password" class="form-control" id="antigua">
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="nueva">Contraseña nueva (min. 8 caracteres)</label>
                                            <input type="password" class="form-control" id="nueva">
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="validar_nueva">Confirmar contraseña (min. 8 caracteres)</label>
                                            <input type="password" class="form-control" id="validar_nueva">
                                        </div>
                                        <div class="col-12 form-group">
                                            <button type="submit" class="btn btn-success btn-block" id="submit_contra">
                                                <i class="fas fa-save"></i>
                                                Cambiar
                                            </button>
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
