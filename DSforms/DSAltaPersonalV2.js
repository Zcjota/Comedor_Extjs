// Configuración del Store para Centros
var storeCentros = new Ext.data.JsonStore({
    url: '../servicesAjax/DSListaCentrosFRAJAX.php',
    root: 'data',
    totalProperty: 'total',
    fields: ['codigop', 'nombrep'],
    autoLoad: true // Carga automática
});

// Configuración del Store para Cargos
var storeCargos = new Ext.data.JsonStore({
    url: '../servicesAjax/DSListaCargosFRAJAX.php',
    root: 'data',
    totalProperty: 'total',
    fields: ['codigop', 'nombrep'],
    autoLoad: true // Carga automática
});

// Configuración del Store para Género
var storeGenero = new Ext.data.ArrayStore({
    fields: ['id', 'nombre'],
    data: [
        ['Masculino', 'Masculino'],
        ['Femenino', 'Femenino']
    ]
});

// Configuración del Store para Extensión (Departamentos de Bolivia + Extranjero)
var storeExtension = new Ext.data.ArrayStore({
    fields: ['id', 'nombre'],
    data: [
        ['LP', 'La Paz'],
        ['CB', 'Cochabamba'],
        ['SC', 'Santa Cruz'],
        ['OR', 'Oruro'],
        ['PT', 'Potosí'],
        ['CH', 'Chuquisaca'],
        ['TA', 'Tarija'],
        ['BE', 'Beni'],
        ['PA', 'Pando'],
        ['EX', 'Extranjero']
    ]
});

function abrirFormularioPersonal(tipo, record) {
    // Combo para Centro
    var centroCombo = new Ext.form.ComboBox({
        fieldLabel: 'Centro',
        name: 'COD_CENTRO',
        hiddenName: 'COD_CENTRO',
        mode: 'local', // Cambiado a local para utilizar los datos del store
        store: storeCentros,
        displayField: 'nombrep',
        valueField: 'codigop',
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
        displayField: 'nombrep',
        valueField: 'codigop',
        triggerAction: 'all',
        emptyText: 'Seleccione Cargo',
        allowBlank: false,
        anchor: '95%'
    });
    var cargoCombo = new Ext.form.ComboBox({
        fieldLabel: 'Cargo',
        name: 'COD_CARGO',
        hiddenName: 'COD_CARGO',
        mode: 'local', // Cambiado a local para utilizar los datos del store
        store: storeCargos,
        displayField: 'nombrep',
        valueField: 'codigop',
        triggerAction: 'all',
        emptyText: 'Seleccione Cargo',
        allowBlank: false,
        anchor: '95%'
    });

    // Combo Género
var generoCombo = new Ext.form.ComboBox({
    fieldLabel: 'Género',
    name: 'GENERO',
    hiddenName: 'GENERO',
    mode: 'local',
    store: storeGenero,
    displayField: 'nombre',
    valueField: 'id',
    triggerAction: 'all',
    emptyText: 'Seleccione Género',
    allowBlank: false,
    anchor: '95%'
});

// Combo Extensión
var extensionCombo = new Ext.form.ComboBox({
    fieldLabel: 'Extensión',
    name: 'EXTENSION',
    hiddenName: 'EXTENSION',
    mode: 'local',
    store: storeExtension,
    displayField: 'nombre',
    valueField: 'id',
    triggerAction: 'all',
    emptyText: 'Seleccione Extensión',
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
                    { columnWidth: 0.25, items: [extensionCombo] },
                    // { columnWidth: 0.25, items: [{ fieldLabel: 'Extensión', name: 'EXTENSION', xtype: 'textfield', style: { textTransform: "uppercase" } }] },
                    { columnWidth: 0.25, items: [{ fieldLabel: 'Fecha de Nacimiento', name: 'FECHA_NACIMIENTO', xtype: 'datefield', format: 'Y-m-d', allowBlank: false }] },
                    { columnWidth: 0.25, items: [generoCombo] },
                    // { columnWidth: 0.25, items: [{ fieldLabel: 'Género', name: 'GENERO', xtype: 'combo', store: [['M', 'Masculino'], ['F', 'Femenino']], triggerAction: 'all', editable: false, emptyText: 'Seleccione Género', allowBlank: false }] }
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
                            url: tipo === 'nuevo' ? '../servicesAjax/DSabmPersonalAjax.php?opcion=nuevo' : '../servicesAjax/DSabmPersonalAjax.php?opcion=modificar',
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
    // console.log(storeCentros.getRange());
    // console.log(storeCargos.getRange());
    
    // Precarga de datos en modo edición
    if (tipo === 'modificar' && record) {
        // Garantizar que los stores están cargados
        storeCentros.load({
            callback: function() {
                centroCombo.setValue(record.get('COD_CENTRO'));
            }
        });
    
        storeCargos.load({
            callback: function() {
                cargoCombo.setValue(record.get('COD_CARGO'));
            }
        });
        // console.log(record.get('COD_CENTRO')); 
        // console.log(record.get('COD_CARGO'));
    
        // Otros valores del formulario
        formPersonal.getForm().loadRecord(record);
    }
    
    



    ventanaPersonal.show();
}
