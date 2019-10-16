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
            path: '/auditoria',
            component: () =>
                import('./../../views/modules/auditoria/AuditoriaLayout.vue'),
            name: 'auditoria',
            children: [{
                path: '/auditoria/home',
                component: () =>
                    // import('./../../views/modules/auditoria/Auditoria.vue')
                    import('./../../views/modules/auditoria/AuditoriaMedicamento.vue')
            }, 
            {
                path: '/auditoria/service',
                component: () =>
                    // import('./../../views/modules/auditoria/AuditoriaService.vue')
                    import('./../../views/modules/auditoria/AuditoriaServicio.vue')
            }, 
            {
                path: '/auditoria/historico',
                component: () =>
                    import('./../../views/modules/auditoria/Historico.vue')
            }, 
            {
                path: '/auditoria/incapacidad',
                component: () =>
                    import('./../../views/modules/auditoria/Incapacidades.vue')
            }]
        },
        {
            path: '/medico',
            component: () =>
                import('./../../views/modules/medico/MedicoLayout.vue'),
            name: 'medico',
            children: [{
                path: '/',
                component: () =>
                    import('./../../views/modules/medico/Medico.vue')
            }, ]
        },
        {
            path: '/historiaclinica',
            component: () =>
                import('./../../views/modules/medico/HistoriaClinicaLayout.vue'),
            name: 'historiaclinica',
            children: [{
                    path: '/',
                    component: () =>
                        import('./../../views/modules/medico/HistoriaClinica.vue'),
                    children: [
                        {
                            path: '/historiaclinica/motivoconsulta',
                            component: () =>
                                import('./../../views/modules/historiaclinica/MotivoConsulta.vue')
                        },
                        {
                            path: '/historiaclinica/gineco',
                            component: () =>
                                import('./../../views/modules/historiaclinica/Gineco.vue')
                        },
                        {
                            path: '/historiaclinica/stylelive',
                            component: () =>
                                import('./../../views/modules/historiaclinica/Stylelife.vue')
                        },
                        {
                            path: '/historiaclinica/patologias',
                            component: () =>
                                import('./../../views/modules/historiaclinica/Patologias.vue')
                        },
                        {
                            path: '/historiaclinica/examensistema',
                            component: () =>
                                import('./../../views/modules/historiaclinica/ExamenSistema.vue')
                        },
                        {
                            path: '/historiaclinica/diagnostico',
                            component: () =>
                                import('./../../views/modules/historiaclinica/Diagnostico.vue')
                        },
                        {
                            path: '/historiaclinica/conducta',
                            component: () =>
                                import('./../../views/modules/historiaclinica/Conducta.vue')
                        },
                        {
                            path: '/historiaclinica/rcvm',
                            component: () =>
                                import('./../../views/modules/historiaclinica/rcvm.vue')
                        },
                        {
                            path: '/historiaclinica/imagenologia',
                            component: () =>
                                import('./../../views/modules/historiaclinica/Imagenologia.vue')
                        },
                    ]
                },

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