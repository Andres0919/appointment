import Layout from '../../views/modules/Layout.vue';

const home = {
    path: '/', 
    component: Layout,
    name: '',
    children: [
        {
            path:'',
            component: () => import('./../../views/modules/dashboard/DashBoard.vue'),
        },
        {
            path:'/agenda',
            component: () => import('./../../views/modules/agendamiento/Agendamiento.vue'),
            name: 'agendamiento',
            children:[
                { path:'/', component: () => import('./../../views/modules/agendamiento/Agenda.vue') },           
                { path:'/agenda/agendamiento-medico', component: () => import('./../../views/modules/agendamiento/AgendamientoMedico.vue') },
                { path:'/agenda/medicos', component: () => import('./../../views/modules/agendamiento/Medicos.vue') },
            ]
        },
        {
            path:'/citas',
            component: () => import('./../../views/modules/citas/CitasLayout.vue'),
            name: 'citas',
            children:[
                { path:'/', component: () => import('./../../views/modules/citas/AsignacionCita.vue') },       
            ]
        },
        {
            path:'/admin',
            component: () => import('./../../views/modules/admin/Admin.vue'),
            name:'admin',
            children:[
                { path:'/admin/users', component: () => import('./../../views/modules/admin/Users.vue') },
                { path:'/admin/tipos-agenda', component: () => import('./../../views/modules/admin/TipoAgenda.vue') },
                { path:'/admin/sedes', component: () => import('./../../views/modules/admin/Sede.vue') },
                { path:'/admin/pacientes', component: () => import('./../../views/modules/admin/Paciente.vue') },
                { path:'/admin/roles', component: () => import('./../../views/modules/admin/Roles.vue') },
            ] 
        }
    ]
} 

export default home;