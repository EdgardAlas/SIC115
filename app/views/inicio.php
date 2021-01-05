<style>
    .clockdate-wrapper {
        background-color: #fff;
        padding:25px;
        max-width:350px;
        width:100%;
        text-align:center;
        border-radius:5px;
        margin:0 auto;
        margin-top:15%;
    }
    #clock{
        background-color:#fff;
        font-family: sans-serif;
        font-size:60px;
        text-shadow:0px 0px 1px #888;
        color:#888;
    }
    #clock span {
        color:#888;
        text-shadow:0px 0px 1px #fff;
        font-size:30px;
        position:relative;
        top:-27px;
        left:-10px;
    }
    #date {
        letter-spacing:10px;
        font-size:14px;
        font-family:arial,sans-serif;
        color:#888;
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>INICIO</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="h4">
                                            Resumen de Cuentas
                                        </h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" id="tree">

                                    </div>
                                </div>
                            </div>
                            <div class="w-100 d-sm-none">
                                &nbsp;
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="clockdate">
                                            <div class="clockdate-wrapper">
                                                <div id="clock"></div>
                                                <div id="date"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
