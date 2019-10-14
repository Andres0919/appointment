<?php

use Illuminate\Http\Request;

// Usuarios
require __DIR__ . '/auth/auth.php';
require __DIR__ . '/auth/password.php';
require __DIR__ . '/usuarios/user.php';
require __DIR__ . '/roles/role.php';
require __DIR__ . '/permisos/permiso.php';
require __DIR__ . '/municipios/municipio.php';
require __DIR__ . '/departamentos/departamento.php';

// Citas
require __DIR__ . '/pacientes/paciente.php';
require __DIR__ . '/tipoagendas/tipoagenda.php';
require __DIR__ . '/especialidades/especialidad.php';
require __DIR__ . '/estados/Estado.php';
require __DIR__ . '/sedes/sede.php';
require __DIR__ . '/consultorios/consultorio.php';
require __DIR__ . '/citas/cita.php';
require __DIR__ . '/agendas/agenda.php';

// Tarifarios
require __DIR__ . '/manuales_tarifarios/tiposervicio.php';
require __DIR__ . '/manuales_tarifarios/tipoprestador.php';
require __DIR__ . '/manuales_tarifarios/cupservicio.php';
require __DIR__ . '/manuales_tarifarios/tipomanuales.php';
require __DIR__ . '/manuales_tarifarios/tipocodigos.php';
require __DIR__ . '/manuales_tarifarios/codesumi.php';
require __DIR__ . '/manuales_tarifarios/codigomanual.php';
require __DIR__ . '/manuales_tarifarios/manuales.php';
require __DIR__ . '/manuales_tarifarios/tarifarios.php';
require __DIR__ . '/manuales_tarifarios/cups.php';
require __DIR__ . '/manuales_tarifarios/codepropios.php';
require __DIR__ . '/manuales_tarifarios/tipofamilia.php';
require __DIR__ . '/manuales_tarifarios/familia.php';
require __DIR__ . '/manuales_tarifarios/contrato.php';

// Medicamentos
require __DIR__ . '/prestadores/prestador.php';
require __DIR__ . '/categorias/categoria.php';
require __DIR__ . '/sedeproveedores/sedeproveedor.php';
require __DIR__ . '/grupos/grupo.php';
require __DIR__ . '/grupos/subgrupo.php';
require __DIR__ . '/articulos/detallearticulo.php';
require __DIR__ . '/proveedores/Proveedor.php';
require __DIR__ . '/proveedores/catalogo.php';
require __DIR__ . '/transaciones/transacion.php';
require __DIR__ . '/transaciones/tipo.php';
require __DIR__ . '/transaciones/tipotransacion.php';
require __DIR__ . '/transaciones/movimiento.php';
require __DIR__ . '/bodegas/tipobodega.php';
require __DIR__ . '/bodegas/bodega.php';
require __DIR__ . '/cargos/cargo.php';

// REPS
require __DIR__ . '/reps/reps.php';

// Historia Clinica
require __DIR__ . '/historiaclinica/tipocita.php';
require __DIR__ . '/historiaclinica/examenfisico.php';
require __DIR__ . '/historiaclinica/conducta.php';
require __DIR__ . '/historiaclinica/diagnostico.php';
require __DIR__ . '/historiaclinica/orden.php';
require __DIR__ . '/historiaclinica/tipoOrden.php';
require __DIR__ . '/historiaclinica/cie10.php';
require __DIR__ . '/historiaclinica/pacienteantecedente.php';
require __DIR__ . '/historiaclinica/parentescoantecede.php';
require __DIR__ . '/historiaclinica/antecedente.php';
require __DIR__ . '/historiaclinica/estilovida.php';
require __DIR__ . '/historiaclinica/gineco.php';
require __DIR__ . '/historiaclinica/parentesco.php';

//Autorizaciones
require __DIR__ . '/autorizaciones/autorizacion.php';
require __DIR__ . '/pdf/pdf.php';



