<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>            
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Alumnos
                    <button type="button" @click="abrirModal('alumno', 'registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>CI</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Sexo</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>IdUsuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="alumno in arrayAlumnos" :key="alumno.id">
                                <td>
                                    <button type="button" @click="abrirModal('alumno', 'actualizar', alumno)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    

                                </td>
                                <td v-text="alumno.nombre"></td>
                                <td v-text="alumno.ci"></td>
                                <td v-text="alumno.fechaNac"></td>
                                <td v-text="alumno.sexo"></td>
                                <td v-text="alumno.direccion"></td>
                                <td v-text="alumno.telefono"></td>
                                <td v-text="alumno.email"></td>
                                                                                                                                                          

                            </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

        <!--Inicio del modal agregar/actualizar-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                
                    <div class="modal-body">

                        <form method="post" enctype="multipart/form-data" class="form-horizontal">                        
                            
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre Completo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre Completo">
                                    <span class="help-block">(*) Ingrese el Nombre completo del alumno</span>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">CI</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ci" @keypress="isNumber($event)" class="form-control" placeholder="Numero Carnet de identidad">
                                    <span class="help-block">(*) Ingrese el Numero de CI del alumno</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">FechaNac</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="fechaNac" class="form-control" placeholder="Fecha de nacimiento">                                    
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Sexo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="sexo" class="form-control" placeholder="Sexo">                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Direccion">                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" @keypress="isNumber($event)" class="form-control" placeholder="Telefono">                                    
                                </div>
                            </div>      
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Email">                                    
                                </div>
                            </div>     
                                                    
                            <div v-show="errorAlumno == 1" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjAlumno" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>                                         
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary" @click="registrarAlumno()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary" @click="actualizarAlumno()">Actualizar</button>
                    </div>                             

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    
    </main>
</template>

<script>
  


    export default {                  
        data() {
            return {               
                idAlumno: 0,
                ci : 0,
                nombre: '',
                fechaNac: '',
                sexo:'',
                direccion: '',
                telefono: '',
                email: '',

                arrayAlumnos: [],

                modal: 0,
                tituloModal: '',

                tipoAccion: 0,

                //variable para los errores
                //bandera para ver si encontro error
                errorAlumno: 0,
                //Array con los errores encontrados
                errorMostrarMsjAlumno: [],

            }
        },

        //propiedades computadas
        computed: {
  
        },

        methods: {
            //Validar que el input solo acepte numeros y punto
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            
            
            listarAlumnos(page, buscar, criterio) {

                let me = this;

                var url = 'http://localhost/Colegio/api/alumnos' ;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data.data;
                        me.arrayAlumnos = respuesta;
                        

                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);

                    })
                    .then(function () {
                        // always executed
                    });
            },
/*
            registrarAlumno() {                
                //Verificar las validaciones
                if (this.validarAlumno()) {
                    return;
                }

                let me = this;                                       

                axios.post(
                    'alumno/registrar',
                    {
                        'nombre': this.nombre,
                        'tipodocumento': this.tipoDocumento,
                        'numdocumento': this.numDocumento,
                        'direccion': this.direccion,
                        'telefono': this.telefono,
                        'email': this.email
                    }                    
                ).then(function (response) {
                    loader.hide();

                    me.cerrarModal();
                    me.listaralumnos(1, '', 'nombre');
                    
                    console.log(response);

                }).catch(function (error) {
                    console.log(error);

                    loader.hide();
                });
            },

            actualizaralumno() {

                //Verificar las validaciones
                if (this.validaralumno()) {
                    return;
                }

                let loader = this.$loading.show(this.optionsLoadingOverlay);

                let me = this;
            
                axios.post(
                    'alumno/actualizar',
                    {
                        'id': this.idAlmacen,
                        'nombre': this.nombre,
                        'tipodocumento': this.tipoDocumento,
                        'numdocumento': this.numDocumento,
                        'direccion': this.direccion,
                        'telefono': this.telefono,
                        'email': this.email                        
                    }                                    
                ).then(function (response) {
                    loader.hide();

                    me.cerrarModal();
                    me.listaralumnos(1, '', 'nombre');
                    
                    console.log(response);

                }).catch(function (error) {
                    console.log(error);

                    loader.hide();
                });
                
            },

  */

            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';

                this.idAlumno= 0;
                this.ci = 0;
                this.nombre= '';
                this.fechaNac= '';
                this.sexo='';
                this.direccion= '';
                this.telefono= '';
                this.email= '';                            
                               
                //limpiar las validaciones
                this.errorAlumno = 0;
                this.errorMostrarMsjAlumno = [];
            },

            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "alumno":
                        switch (accion) {
                            case "registrar":
                                this.modal = 1;
                                this.tituloModal = "Registrar alumno";
                                this.tipoAccion = 1;

                                this.idAlumno= 0;
                                this.ci = 0;
                                this.nombre= '';
                                this.fechaNac= '';
                                this.sexo='';
                                this.direccion= '';
                                this.telefono= '';
                                this.email= '';                                                                                            
                                break;

                            case "actualizar":
                                //console.log(data);                              
                                this.modal = 1;
                                this.tituloModal = 'Actualizar alumno';
                                this.tipoAccion = 2;

                                this.idAlumno= data['idAlumno'];
                                this.ci = data['ci'];
                                this.nombre= data['nombre'];
                                this.fechaNac= data['frechaNac'];
                                this.sexo=data['sexo'];
                                this.direccion= data['direccion'];
                                this.telefono= data['telefono'];
                                this.email= data['email'];
                                                         
                                break;
                        
                            default:
                                break;
                        }
                        break;
                
                    default:
                        break;
                }
            },
        /*  
            validarAlumno() {
                this.erroralumno = 0;                
                this.errorMostrarMsjalumno = [];

                if (!this.nombre) {
                    this.errorMostrarMsjalumno.push("El campo nombre no puede estar vacio.");
                }

                if (!this.numDocumento) {
                    this.errorMostrarMsjalumno.push("El campo Numero de Documento no puede estar vacio.");
                }                                                             
                
                if (this.errorMostrarMsjalumno.length) {
                    this.erroralumno = 1;
                }

                return this.erroralumno;
            },                        
        */
        },
       
        mounted() {
            //console.log('Component mounted.')
            this.listarAlumnos(1, this.buscar, this.criterio);                        
        }
    }
    
</script>

<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3C29297A !important;
    }

    .div-error {
        display: flex;
        justify-content: center;        
    }
    .text-error {
        color: red !important;
        font-weight: bold;
    }

</style>