import Vue from 'vue'
import Router from 'vue-router'

//importar componentes
import UsuariosListado from './components/usuarios/Listado.vue'
import UsuariosFormulario from './components/usuarios/Formulario.vue'

import EntidadesListado from './components/entidades/Listado.vue'
import EntidadesFormulario from './components/entidades/Formulario.vue'

import CrearEntidadUsuario from './components/entidadUsuario/CrearEntidadUsuario.vue'
import EditarEntidadUsuario from './components/entidadUsuario/EditarEntidadUsuario.vue'

import ProductosListado from './components/productos/Listado.vue'
import ProductosFormulario from './components/productos/Formulario.vue'

import Administrador from './components/administrador/Administrador.vue'
import Invitado from './components/invitado/Invitado.vue'
import Localidades from './components/invitado/Localidades.vue'
import Entidades from './components/invitado/Entidades.vue'
import Producto from './components/invitado/Producto.vue'
import Productos from './components/invitado/Productos.vue'
import ProductosAll from './components/invitado/ProductosAll.vue'
import AnunciateFormulario from './components/anunciate/Formulario.vue'
import AnunciateListado from './components/anunciate/Listado.vue'

import PagoListado from './components/pagos/Listado.vue'
import PagoFormulario from './components/pagos/Formulario.vue'

import Password from './components/usuarios/Password.vue'

import RedesListado from './components/redes/Listado.vue'
import RedesFormulario from './components/redes/Formulario.vue'
import RedesFormularioEntidadRed from './components/redes/FormularioEntidadRed.vue'
import RedesListadoEntidadRed from './components/redes/ListadoEntidadRed.vue'

import AdministradorEditarEmpresa from './components/administrador/EditarEmpresa.vue'
import AdministradorUsuariosListado from './components/administrador/usuarios/Listado.vue'
import AdministradorUsuariosFormulario from './components/administrador/usuarios/Formulario.vue'

import CategoriaEntidadListado from './components/categoriaEntidad/Listado.vue'
import CategoriaEntidadFormulario from './components/categoriaEntidad/Formulario.vue'
//-----

Vue.use(Router)

export default new Router({
	//mode: 'history',
	routes: [
		/*	
		{ 
			path: '/', 
			redirect: '/pagina-principal'
		},
		*/	
		//administrador
		{
			path: '/panel-de-administrador',
			name: 'administrador-administrador',
			component: Administrador
		},
		{
			path: '/listado-de-usuarios-dados-de-alta/:idEmpresa',
			name: 'administrador-usuarios-listado',
			component: AdministradorUsuariosListado
		},
		{
			path: '/creacion-del-nuevo-usuario-para-el-sistema/:idEmpresa/:idUsuario?',
			name: 'administrador-usuarios-formulario',
			component: AdministradorUsuariosFormulario
		},		
		//rutas a usuarios
		{
			path: '/listado-usuarios',
			name: 'listado-usuarios',
			component: UsuariosListado
		},
		{
			path: '/crear-usuarios',
			name: 'crear-usuarios',
			component: UsuariosFormulario
		},
		{
			path: '/editar-usuarios/:idUser',
			name: 'editar-usuarios',
			component: UsuariosFormulario
		},
		{
			path: '/cambiar-password/:idUser',
			name: 'cambiar-password',
			component: Password
		},
		//rutas a entidades
		{
			path: '/listado-entidades',
			name: 'listado-entidades',
			component: EntidadesListado
		},
		{
			path: '/crear-entidades',
			name: 'crear-entidades',
			component: EntidadesFormulario
		},
		{
			path: '/editar-entidades/:idEntidad',
			name: 'editar-entidades',
			component: EntidadesFormulario
		},
		{
			path: '/editar-empresa/:idEmpresa',
			name: 'editar-empresa',
			component: AdministradorEditarEmpresa
		},

		//RUTAS CATEGORIAS_ENTIDAD
		{
			path: '/listado-categorias-entidad',
			name: 'listado-categorias-entidad',
			component: CategoriaEntidadListado
		},
		{
			path: '/crear-categoria-entidad',
			name: 'crear-categoria-entidad',
			component: CategoriaEntidadFormulario
		},
		{
			path: '/editar-categoria-entidad/:idCatEnt',
			name: 'editar-categoria-entidad',
			component: CategoriaEntidadFormulario
		},	

		//rutas a Empresa Usuario
		{
			path: '/crear-entidad-usuario',
			name: 'crear-entidad-usuario',
			component: CrearEntidadUsuario
		},

		{
			path: '/editar-entidad-usuario/:id/:quien',
			name: 'editar-entidad-usuario',
			component: EditarEntidadUsuario
		},

		//rutas a productos
		{
			path: '/listado-productos',
			name: 'listado-productos',
			component: ProductosListado
		},
		{
			path: '/crear-productos/:idEntidad',
			name: 'crear-productos',
			component: ProductosFormulario
		},
		{
			path: '/editar-productos/:idProducto',
			name: 'editar-productos',
			component: ProductosFormulario
		},


		//rutas a invitado
		{
			path: '/pagina-principal',
			name: 'invitado-invitado',
			component: Invitado
		},
		{
			path: '/localidades-disponibles/:idProvincia',
			name: 'invitado-localidades',
			component: Localidades
		},
		{
			path: '/listados-de-comercios-y-servicios/:idLocalidad/:idEntidadCategoria?',
			name: 'invitado-entidades',
			component: Entidades
		},
		{
			path: '/vista-del-producto/:idProducto/:idLocalidad/:idEntidad',
			name: 'invitado-producto',
			component: Producto
		},
		{
			path: '/listado-de-productos-o-servicios-disponibles/:idLocalidad/:idEntidad?',
			name: 'invitado-productos',
			component:Productos
		},
		{
			path: '/listado-de-productos-o-servicios-disponibles-en-la-localidad/:idLocalidad',
			name: 'invitado-productosAll',
			component:ProductosAll
		},

		//ANUNCIATE
		{
			path: '/anunciate-formulario/:idEntidad',
			name: 'anunciate-formulario',
			component: AnunciateFormulario
		},
		{
			path: '/anunciate-listado',
			name: 'anunciate-listado',
			component: AnunciateListado
		},

		//PAGOS
		{
			path: '/listado-pagos',
			name: 'listado-pagos',
			component: PagoListado
		},
		{
			path: '/crear-pago/:idEntidad/:entidad',
			name: 'crear-pago',
			component: PagoFormulario
		},

		//rutas a redes
		{
			path: '/listado-redes',
			name: 'listado-redes',
			component: RedesListado
		},
		{
			path: '/crear-redes',
			name: 'crear-redes',
			component: RedesFormulario
		},

		{
			path: '/crear-entidad-red',
			name: 'crear-entidad-red',
			component: RedesFormularioEntidadRed
		},
		{
			path: '/editar-entidad-red/:idEntidadRed',
			name: 'editar-entidad-red',
			component: RedesFormularioEntidadRed
		},
		{
			path: '/listado-entidad-redes',
			name: 'listado-entidad-redes',
			component: RedesListadoEntidadRed
		},
		{
			path: '/editar-red/:idRed',
			name: 'editar-red',
			component: RedesFormulario
		}
	],
	
	//mode: 'history' //evita el # en las rutas

})