<?php

require "Conexion.php";

class Administrador extends Conexion{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $carnet;
    protected $salario;
    protected $telefono;
    protected $correo;
    protected $password;
    protected $id_departamento;
    protected $id_rol;
    protected $id_estado;

    /** CRUD de administradores */
    //metodo para obtener todos los departamentos
    public function departamentos(){
        $this->conectar();
        $query = "SELECT * FROM departamento";
        //ejecutando la consulta => mysqli_query()
        $resultado = mysqli_query($this->conexion, $query);
        return $resultado;
    }

    public function roles(){
        $this->conectar();
        $query = "SELECT * FROM rol";
        //ejecutando la consulta => mysqli_query()
        $resultado2 = mysqli_query($this->conexion, $query);
        return $resultado2;
    }

    //metodo para registrar el administrador utilizando el formulario de html
    public function insertar(){
        //isset() => verifica si los campos del formulario no estan vacios
        if(isset($_POST['nombre'], $_POST['apellido'], $_POST['salario'], $_POST['carnet'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['departamento'])){

            //asignando a las propiedades los campos del formulario
            $this->nombre = $_POST['nombre'];
            $this->apellido = $_POST['apellido'];
            $this->salario = $_POST['salario'];
            $this->carnet = $_POST['carnet'];
            $this->telefono = $_POST['telefono'];
            $this->correo = $_POST['correo'];
            $this->password = $_POST['password'];
            $this->id_departamento = $_POST['departamento'];
            $this->id_rol = 2; //2 = Administrador

            //consulta para insertar en la base de datos
            $query = "INSERT INTO administrador(nombre, apellido, salario, carnet, telefono, correo, password, id_departamento,id_rol) VALUES ('$this->nombre', '$this->apellido', $this->salario, '$this->carnet', $this->telefono, '$this->correo', '$this->password', $this->id_departamento, $this->id_rol)";

            $result = mysqli_query($this->conexion, $query);
            //validando que se haya guardado el registro y retorne a otra vista

            //empty => verifica si algo esta vacio o no
            if(!empty($result)){
                //redireccionando al index
                header("location: administradores.php");
            }else{
                echo "Error al registrar el administrador";
            }
        }
    }

    //obteniendo todos los administradores
    public function getAdministradores(){
        $this->conectar();
        $query = "SELECT administrador.*, departamento.nombre AS departamento  FROM administrador INNER JOIN departamento ON administrador.id_departamento = departamento.id";
        $result = mysqli_query($this->conexion, $query);
        return $result;
    }

    //obteniendo un administrador en base a su id
    public function getAdministradorById(){
        if(isset($_POST['id_administrador'])){
            $this->id = $_POST['id_administrador'];
            $this->conectar();
            $query = "SELECT administrador.*, departamento.nombre AS departamento  FROM administrador INNER JOIN departamento ON administrador.id_departamento = departamento.id  WHERE administrador.id = $this->id";
            $result = mysqli_query($this->conexion, $query);
            return $result; //[]
        }
        
    }

    //actualizando el administrador
    public function actualizar(){
        if(isset($_POST['nombre'], $_POST['apellido'], $_POST['salario'], $_POST['carnet'], $_POST['telefono'], $_POST['correo'], $_POST['password'], $_POST['departamento'], $_POST['id_administrador'])){

            //asignando a las propiedades los campos del formulario
            $this->nombre = $_POST['nombre'];
            $this->apellido = $_POST['apellido'];
            $this->salario = $_POST['salario'];
            $this->carnet = $_POST['carnet'];
            $this->telefono = $_POST['telefono'];
            $this->correo = $_POST['correo'];
            $this->password = $_POST['password'];
            $this->id_departamento = $_POST['departamento'];
            $this->id = $_POST['id_administrador'];

            //consulta para actualizar un administrador por su id
            $query = "UPDATE administrador SET nombre = '$this->nombre', apellido = '$this->apellido', salario = $this->salario, carnet = '$this->carnet', telefono = $this->telefono, correo = '$this->correo', password = '$this->password', id_departamento = $this->id_departamento WHERE id = $this->id";

            $result = mysqli_query($this->conexion, $query);
            //validando que se haya guardado el registro y retorne a otra vista

            //empty => verifica si algo esta vacio o no
            if(!empty($result)){
                //redireccionando al index
                header("location: administradores.php");
            }else{
                echo "Error al actualizar el administrador";
            }
        }
    }

    //Eliminando administrador
    public function eliminar(){
        if(isset($_POST['id_administrador'])){
            $this->id = $_POST['id_administrador']; //6
            $this->conectar();
            $query = "DELETE FROM administrador WHERE id = $this->id";
            $result = mysqli_query($this->conexion, $query);
            if(!empty($result)){
                echo "";
            }else{
                echo "No se pudo eliminar el administrador";
            }
        }
    }
}


?>