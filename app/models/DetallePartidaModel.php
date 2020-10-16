<?php

require_once './app/libs/Model.php';

class DetallePartidaModel extends Model
{
    private $tabla;

    private $validaciones;

    public function __construct($conexion)
    {
        $this->tabla = "detalle_partida";

        parent::__construct($this->tabla, $conexion);
    }

    public function validarCampos($datos)
    {
        return $this->_validarCampos($datos, $this->validaciones);
    }

    public function obtenerLibroDiario($condicion = array())
    {
        if ($condicion['numero'][0] !== '') {
            $data = array();
            $partidas = $condicion['numero'];
            
            foreach ($partidas as $key => $partida) {
                $partida = $this->conexion()->query("
                    SELECT
                    partida.fecha,
                    partida.numero,
                    partida.descripcion,
                    CONCAT(cuenta.codigo,' - ', cuenta.nombre) cuenta,
                    cuenta.codigo,
                    detalle.movimiento,
                    detalle.monto
                        from detalle_partida detalle
                        inner join partida on detalle.partida = partida.id
                        inner join periodo on partida.periodo = periodo.id
                        inner join empresa on periodo.empresa = empresa.id
                        inner join cuenta on detalle.cuenta = cuenta.id
                            where periodo.id = :periodo and empresa.id = :empresa and
                            partida.fecha between :fecha_inicial and :fecha_final and partida.numero = :numero
                            ", array(
                        ':periodo' => $condicion['periodo'],
                        ':empresa' => $condicion['empresa'],
                        ':fecha_inicial' => $condicion['fecha_inicial'],
                        ':fecha_final' => $condicion['fecha_final'],
                        ':numero' => $partida
                ))->fetchAll();

                foreach ($partida as $i => $partida_separada) {
                    $data[] = $partida_separada;
                }
                
            }
            
            return $data;
        }

        return ( $this->conexion()->query("
        SELECT
        partida.fecha,
        partida.numero,
        partida.descripcion,
        CONCAT(cuenta.codigo,' - ', cuenta.nombre) cuenta,
        cuenta.codigo,
        detalle.movimiento,
        detalle.monto
            from detalle_partida detalle
            inner join partida on detalle.partida = partida.id
            inner join periodo on partida.periodo = periodo.id
            inner join empresa on periodo.empresa = empresa.id
            inner join cuenta on detalle.cuenta = cuenta.id
                where periodo.id = :periodo and empresa.id = :empresa and
                partida.fecha between :fecha_inicial and :fecha_final
                ", array(
            ':periodo' => $condicion['periodo'],
            ':empresa' => $condicion['empresa'],
            ':fecha_inicial' => $condicion['fecha_inicial'],
            ':fecha_final' => $condicion['fecha_final'],
        ))->fetchAll());
    }

    public function obtenerDebeHaber($cuentas, $condicion)
    {

        foreach ($cuentas as $key => $cuenta) {

            $auxiliar_consulta = $this->conexion()->query("select detalle_partida.movimiento movimiento,
            sum(monto) monto
                from detalle_partida inner join partida on partida.id = detalle_partida.partida
                inner join cuenta on cuenta.id = detalle_partida.cuenta
            inner join periodo on periodo.id = partida.periodo
            where cuenta.codigo like :codigo and partida.fecha between :fecha_inicial and :fecha_final
            and periodo.id = :periodo and partida.partida_cierre = 0 group by movimiento order by movimiento desc", array(
                ':fecha_inicial' => $condicion['fecha_inicial'],
                ':fecha_final' => $condicion['fecha_final'],
                ':periodo' => $condicion['periodo'],
                ':codigo' => $cuenta['codigo'] . '%',
            ))->fetchAll();

            foreach ($auxiliar_consulta as $indice => $consulta) {

                if ($consulta['movimiento'] === 'Cargo') {
                    $cuentas[$key]['debe'] = ($consulta['monto']);
                }

                if ($consulta['movimiento'] === 'Abono') {
                    $cuentas[$key]['haber'] = ($consulta['monto']);
                }

            }
        }

        return $cuentas;
    }

}
