<?php
require_once("controladores/conexion.php");
require_once("modelos/Producto.php");

class Producto_controller extends conexion {

    public function listar() {
        $sql = "SELECT p.*, m.id AS medida_id, m.nombre AS medida, c.id AS categoria_id, c.nombre AS categoria 
                FROM productos p 
                INNER JOIN medidas m ON p.id_medida = m.id 
                INNER JOIN categorias c ON p.id_categoria = c.id";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = $fila;
        }
        return $resultado;
    }

    public function existeProducto($dui) {
        $sql = "SELECT COUNT(*) as count FROM productos WHERE codigo = '".$dui."'";
        $rs = $this->ejecutarSQL($sql);
        if ($rs === false) {
            // Maneja el error en la ejecución de la consulta SQL
            throw new Exception("Error al ejecutar la consulta SQL");
        }
        $fila = $rs->fetch_assoc();
        return $fila['count'] > 0; // Devuelve true si existe, false en caso contrario
    }

    public function CantidadProductos() {
        $sql = "SELECT COUNT(id) AS count FROM productos";
        $rs = $this->ejecutarSQL($sql);
        return $this->obtenerConteo($rs);
    }
    
    public function CantidadClientes() {
        $sql = "SELECT COUNT(id) AS count FROM clientes";
        $rs = $this->ejecutarSQL($sql);
        return $this->obtenerConteo($rs);
    }
    
    public function CantidadUsuarios() {
        $sql = "SELECT COUNT(id) AS count FROM usuarios";
        $rs = $this->ejecutarSQL($sql);
        return $this->obtenerConteo($rs);
    }
    public function VentasDelDia() {
        $sql = "SELECT COUNT(*) AS count FROM ventas WHERE fecha > CURDATE()";
        $rs = $this->ejecutarSQL($sql);
        return $this->obtenerConteo($rs);
    }
    
    private function obtenerConteo($rs) {
        if ($rs) {
            $row = $rs->fetch_assoc(); // Obtener la fila de resultados como un array asociativo
            return isset($row['count']) ? $row['count'] : 0; // Retornar el valor del conteo
        }
        return 0; // En caso de error, retornar 0 o manejar el error de otra manera
    }
    
    

    public function mostrarMedida(){
        $sql = "SELECT * FROM medidas";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = $fila;
            
        }
        
        return $resultado;
    }
    
    public function mostrarProducto(){
        $sql = "SELECT * FROM productos";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = $fila;
            
        }
        
        return $resultado;
    }

    public function MenorCantidadProductos(){
        $sql = "SELECT * FROM productos WHERE cantidad < 50 ORDER BY cantidad DESC LIMIT 10";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = $fila;
            
        }
        
        return $resultado;
    }
    
    public function ProductosMasVendidos() {
        $sql = "SELECT d.id_producto, p.descripcion, SUM(d.cantidad) AS total 
                FROM detalle_ventas d 
                INNER JOIN productos p ON p.id = d.id_producto 
                GROUP BY d.id_producto, p.descripcion 
                ORDER BY total DESC 
                LIMIT 10";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = $fila;
        }
        return $resultado;
    }


    public function ProductosCantidadCero() {
        $sql = "SELECT * FROM productos WHERE cantidad = 0";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()) {
            $resultado[] = $fila;
        }
        return $resultado;
    }


    public function mostrarCategoria(){
        $sql = "SELECT * FROM categorias";
        $rs = $this->ejecutarSQL($sql);
        $resultado = array();
        while ($fila = $rs->fetch_assoc()){ 
            $resultado[] = $fila;
            
        }
        
        return $resultado;
    }

    public function agregar($producto) {
        $sql = "INSERT INTO productos (codigo, descripcion, precio_compra, precio_venta,cantidad, id_medida, id_categoria, foto, id_proveedor)
                VALUES (
                    '".$producto->getCodigo()."',
                    '".$producto->getDescripcion()."',
                    '".$producto->getPrecioCompra()."',
                    '".$producto->getPrecioVenta()."',
                    '".$producto->getCantidad()."',
                    '".$producto->getIdMedida()."',
                    '".$producto->getIdCategoria()."',
                    '".$producto->getFoto()."',
                    '".$producto->getProveedor()."'
                )";
        $this->ejecutarSQL($sql);
    }

    public function eliminar($id) {
        $sql = "UPDATE productos SET estado = 0 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function activar($id) {
        $sql = "UPDATE productos SET estado = 1 WHERE id = '".$id."'";
        $this->ejecutarSQL($sql);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $rs = $this->ejecutarSQL($sql);
        $fila = $rs->fetch_assoc();
        return $fila;  // Ajustado para devolver una matriz asociativa en lugar de un objeto
    }

    public function buscarPorCodigo($codigo) {
        $sql = "SELECT * FROM productos WHERE codigo = '$codigo'";
        $rs = $this->ejecutarSQL($sql);
        if ($fila = $rs->fetch_assoc()) {
            return new Producto(
                $fila["id"],
                $fila["codigo"],
                $fila["descripcion"],
                $fila["precio_compra"],
                $fila["precio_venta"],
                $fila["cantidad"],
                $fila["id_medida"],
                $fila["id_categoria"],
                $fila["foto"],
                $fila["estado"]
            );
        } else {
            return null;
        }
    }

    public function buscarProductoPorCodigo() {
        if(isset($_POST['codigoProducto'])){
            $codigoProducto = $_POST['codigoProducto'];
            $producto = $this->buscarPorCodigo($codigoProducto);
            if($producto){
                echo json_encode($producto);
            } else {
                echo json_encode(false);
            }
        }
    }

    public function revertirCantidadProducto($productoId, $cantidad) {
        // Obtener el producto actual
        $producto = $this->obtenerPorId($productoId);

        // Actualizar la cantidad del producto
        $nuevaCantidad = $producto['cantidad'] - $cantidad;

        // Guardar la nueva cantidad en la base de datos
        $this->actualizarCantidad($productoId, $nuevaCantidad);
    }

    public function RestarCantidadProducto($productoId, $cantidad) {
        // Obtener el producto actual
        $producto = $this->obtenerPorId($productoId);

        // Actualizar la cantidad del producto
        $nuevaCantidad = $producto['cantidad'] + $cantidad;

        // Guardar la nueva cantidad en la base de datos
        $this->actualizarCantidad($productoId, $nuevaCantidad);
    }

    public function actualizarCantidad($productoId, $nuevaCantidad) {
        $sql = "UPDATE productos SET cantidad = $nuevaCantidad WHERE id = $productoId";
        $this->ejecutarSQL($sql);
    }


    public function actualizar($producto) {
        $sql = "UPDATE productos SET 
                    codigo = '".$producto->getCodigo()."',
                    descripcion = '".$producto->getDescripcion()."',
                    precio_compra = '".$producto->getPrecioCompra()."',
                    precio_venta = '".$producto->getPrecioVenta()."',
                    cantidad = '".$producto->getCantidad()."',
                    id_medida = '".$producto->getIdMedida()."',
                    id_categoria = '".$producto->getIdCategoria()."',
                    foto = '".$producto->getFoto()."'
                WHERE id = '".$producto->getId()."'";
        $this->ejecutarSQL($sql);
    }

    public function actualizarCantidadProducto($id, $cantidad) {
        $sql = "UPDATE productos SET cantidad = cantidad - $cantidad WHERE id = '$id'";
        $this->ejecutarSQL($sql);
    }
}
?>
