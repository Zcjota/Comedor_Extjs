// Configuración del Store para Centros
var storeCentros = new Ext.data.JsonStore({
    url: '../servicesAjax/getCentros.php',
    root: 'data',
    totalProperty: 'total',
    fields: ['id', 'descripcion'],
    autoLoad: true // Carga automática
});

// Configuración del Store para Cargos
var storeCargos = new Ext.data.JsonStore({
    url: '../servicesAjax/getCargos.php',
    root: 'data',
    totalProperty: 'total',
    fields: ['id', 'descripcion'],
    autoLoad: true // Carga automática
});

function abrirFormularioPersonal(tipo, record) {
    // Combo para Centro
    var centroCombo = new Ext.form.ComboBox({
        fieldLabel: 'Centro',
        name: 'COD_CENTRO',
        hiddenName: 'COD_CENTRO',
        mode: 'local', // Cambiado a local para utilizar los datos del store
        store: storeCentros,
        displayField: 'descripcion',
        valueField: 'id',
        triggerAction: 'all',
        emptyText: 'Seleccione Centro',
        allowBlank: false,
        anchor: '95%'
    });

    // Combo para Cargo
    var cargoCombo = new Ext.form.ComboBox({
        fieldLabel: 'Cargo',
        name: 'COD_CARGO',
        hiddenName: 'COD_CARGO',
        mode: 'local', // Cambiado a local para utilizar los datos del store
        store: storeCargos,
        displayField: 'descripcion',
        valueField: 'id',
        triggerAction: 'all',
        emptyText: 'Seleccione Cargo',
        allowBlank: false,
        anchor: '95%'
    });

    // Formulario
    var formPersonal = new Ext.FormPanel({
        labelAlign: 'top',
        frame: true,
        bodyStyle: 'padding:10px;',
        autoHeight: true,
        layout: 'form',
        defaults: { anchor: '95%', xtype: 'textfield' },
        items: [
            {
                xtype: 'fieldset',
                title: 'Información Personal',
                layout: 'column',
                defaults: { layout: 'form', border: false, anchor: '95%' },
                items: [
                    { columnWidth: 0.5, items: [{ fieldLabel: 'Nombre', name: 'NOMBRE', xtype: 'textfield', allowBlank: false, style: { textTransform: "uppercase" } }] },
                    { columnWidth: 0.5, items: [{ fieldLabel: 'Segundo Nombre', name: 'NOMBRE2', xtype: 'textfield', style: { textTransform: "uppercase" } }] },
                    { columnWidth: 0.5, items: [{ fieldLabel: 'Apellido Paterno', name: 'AP_PATERNO', xtype: 'textfield', allowBlank: false, style: { textTransform: "uppercase" } }] },
                    { columnWidth: 0.5, items: [{ fieldLabel: 'Apellido Materno', name: 'AP_MATERNO', xtype: 'textfield', allowBlank: false, style: { textTransform: "uppercase" } }] }
                ]
            },
            {
                xtype: 'fieldset',
                title: 'Identificación',
                layout: 'column',
                defaults: { layout: 'form', border: false, anchor: '95%' },
                items: [
                    { columnWidth: 0.25, items: [{ fieldLabel: 'CI', name: 'CI', xtype: 'numberfield', allowBlank: false }] },
                    { columnWidth: 0.25, items: [{ fieldLabel: 'Extensión', name: 'EXTENSION', xtype: 'textfield', style: { textTransform: "uppercase" } }] },
                    { columnWidth: 0.25, items: [{ fieldLabel: 'Fecha de Nacimiento', name: 'FECHA_NACIMIENTO', xtype: 'datefield', format: 'Y-m-d', allowBlank: false }] },
                    { columnWidth: 0.25, items: [{ fieldLabel: 'Género', name: 'GENERO', xtype: 'combo', store: [['M', 'Masculino'], ['F', 'Femenino']], triggerAction: 'all', editable: false, emptyText: 'Seleccione Género', allowBlank: false }] }
                ]
            },
            {
                xtype: 'fieldset',
                title: 'Contacto',
                layout: 'column',
                defaults: { layout: 'form', border: false, anchor: '95%' },
                items: [
                    { columnWidth: 0.33, items: [{ fieldLabel: 'Teléfono', name: 'TELEFONO', xtype: 'numberfield', allowBlank: false }] },
                    { columnWidth: 0.33, items: [{ fieldLabel: 'Celular', name: 'CELULAR', xtype: 'numberfield', allowBlank: false }] },
                    { columnWidth: 0.34, items: [{ fieldLabel: 'Dirección', name: 'DIRECCION', xtype: 'textfield', allowBlank: false, style: { textTransform: "uppercase" } }] }
                ]
            },
            {
                xtype: 'fieldset',
                title: 'Información Laboral',
                layout: 'column',
                defaults: { layout: 'form', border: false, anchor: '80%' },
                items: [
                    { columnWidth: 0.33, items: [centroCombo] },
                    { columnWidth: 0.33, items: [cargoCombo] },
                    { columnWidth: 0.34, items: [{ fieldLabel: 'Fecha de Ingreso', name: 'FECHA_INGRESO', xtype: 'datefield', format: 'Y-m-d', allowBlank: false }] }
                ]
            }
        ]
    });

    // Ventana
    var ventanaPersonal = new Ext.Window({
        title: tipo === 'nuevo' ? 'Nuevo Personal' : 'Modificar Personal',
        width: 750,
        autoHeight: true,
        layout: 'fit',
        modal: true,
        items: [formPersonal],
        buttons: [
            {
                text: 'Guardar',
                handler: function () {
                    if (formPersonal.getForm().isValid()) {
                        formPersonal.getForm().submit({
                            url: tipo === 'nuevo' ? '../servicesAjax/crearPersonal.php?opcion=nuevo' : '../servicesAjax/crearPersonal.php?opcion=modificar',
                            params: tipo === 'modificar' ? { COD_PERSONAL: record.get('COD_PERSONAL') } : {},
                            success: function () {
                                Ext.namespace.storePersonal.reload();
                                ventanaPersonal.close();
                                Ext.MessageBox.alert('Éxito', 'Datos guardados correctamente.');
                            },
                            failure: function (form, action) {
                                Ext.MessageBox.alert('Error', action.result.errors.reason || 'No se pudieron guardar los datos.');
                            }
                        });
                    }
                }
            },
            {
                text: 'Cancelar',
                handler: function () {
                    ventanaPersonal.close();
                }
            }
        ]
    });

    // Precarga de datos en modo edición
  // Precarga de datos en modo edición
if (tipo === 'modificar' && record) {
    formPersonal.getForm().loadRecord(record);

    // Configurar el valor del combo Centro
    var indexCentro = storeCentros.findExact('id', record.get('COD_CENTRO'));
    if (indexCentro !== -1) {
        centroCombo.setValue(storeCentros.getAt(indexCentro).get('descripcion'));
    }

    // Configurar el valor del combo Cargo
    var indexCargo = storeCargos.findExact('id', record.get('COD_CARGO'));
    if (indexCargo !== -1) {
        cargoCombo.setValue(storeCargos.getAt(indexCargo).get('descripcion'));
    }
}


    ventanaPersonal.show();
}
