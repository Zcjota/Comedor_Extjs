Ext.onReady(function() {
    // Definición del Store
    Ext.namespace.storePersonal = new Ext.data.JsonStore({
        url: '../servicesAjax/DSdesactivarPersonalAJAX.php',
        root: 'data',
        totalProperty: 'total',
        fields: ['COD_PERSONAL', 'NOMBRE', 'NOMBRE2', 'AP_PATERNO', 'AP_MATERNO', 'CI', 'EXTENSION', 'FECHA_NACIMIENTO',
            'GENERO', 'DIRECCION', 'TELEFONO', 'CELULAR', 'NOMBRE_CENTRO', 'NOMBRE_CARGO','COD_CENTRO', 'COD_CARGO', 'FECHA_INGRESO', 'COD_NIVEL']
    });

    // Barra de paginación
    var pagingBar = new Ext.PagingToolbar({
        pageSize: 50,
        store: Ext.namespace.storePersonal,
        displayInfo: true,
        displayMsg: 'Mostrando {0} - {1} de {2}',
        emptyMsg: 'No hay datos para mostrar.'
    });

    // Combo para filtrar por estado
    var estadoCombo = new Ext.form.ComboBox({
        fieldLabel: 'Estado',
        store: new Ext.data.SimpleStore({
            fields: ['value', 'text'],
            data: [['1', 'Activo'], ['0', 'Inactivo'], ['2', 'Ambos']]
        }),
        displayField: 'text',
        valueField: 'value',
        mode: 'local',
        triggerAction: 'all',
        emptyText: 'Seleccione estado',
        editable: false,
        value: '2'
    });

    // Campo de texto para buscar
    var searchField = new Ext.form.TextField({
        width: 200,
        emptyText: 'Buscar por CI, Nombre o Apellido',
        enableKeyEvents: true
    });

    // Función para cargar los datos del Store
    function cargarDatos() {
        Ext.namespace.storePersonal.load({
            params: {
                start: 0,
                limit: 50,
                activo: estadoCombo.getValue() === '2' ? 1 : estadoCombo.getValue(),
                inactivo: estadoCombo.getValue() === '2' ? 1 : (estadoCombo.getValue() === '1' ? 0 : 1),
                buscar: searchField.getValue()
            }
        });
    }

    // Listeners para el combo y el campo de texto
    estadoCombo.on('select', cargarDatos);
    searchField.on('keyup', function(field, e) {
        if (e.getKey() === Ext.EventObject.ENTER || e.getKey() === Ext.EventObject.TAB) {
            cargarDatos();
        }
    });

    // Modelo de columnas para el Grid
    var personalColumnModel = new Ext.grid.ColumnModel([
        { header: 'ID', dataIndex: 'COD_PERSONAL', width: 50, hidden: true },
        { header: 'Nombre', dataIndex: 'NOMBRE', width: 100, sortable: true },
        { header: 'Segundo Nombre', dataIndex: 'NOMBRE2', width: 100 },
        { header: 'Apellido Paterno', dataIndex: 'AP_PATERNO', width: 100 },
        { header: 'Apellido Materno', dataIndex: 'AP_MATERNO', width: 100 },
        { header: 'CI', dataIndex: 'CI', width: 80 },
        { header: 'Ext.', dataIndex: 'EXTENSION', width: 50 },
        { header: 'Fecha Nac.', dataIndex: 'FECHA_NACIMIENTO', width: 100 },
        { header: 'Género', dataIndex: 'GENERO', width: 80 },
        { header: 'Centro', dataIndex: 'NOMBRE_CENTRO', width: 150 },
        { header: 'Cargo', dataIndex: 'NOMBRE_CARGO', width: 150 },
        { header: 'Fecha Ingreso', dataIndex: 'FECHA_INGRESO', width: 100 }
    ]);

    // Grid de Personal
    // Grid de Personal
var personalGrid = new Ext.grid.GridPanel({
    id: 'personalGrid',
    store: Ext.namespace.storePersonal,
    cm: personalColumnModel,
    loadMask: true,
    stripeRows: true,
    region: 'center',
    bbar: pagingBar,
    tbar: [
        {
            text: 'Nuevo',
            icon: '../img/Nuevo.png',
            handler: function() {
                abrirFormularioPersonal('nuevo');
            }
        },
        '-',
        {
            text: 'Modificar',
            icon: '../img/Editar.png',
            handler: function() {
                var selModel = personalGrid.getSelectionModel();
                if (selModel.hasSelection()) {
                    var record = selModel.getSelected();
                    abrirFormularioPersonal('modificar', record);
                } else {
                    Ext.MessageBox.alert('Advertencia', 'Seleccione un registro para modificar.');
                }
            }
        },
        '-',
        {
            text: 'Eliminar',
            icon: '../img/Eliminar.png',
            handler: function() {
                var selModel = personalGrid.getSelectionModel();
                if (selModel.hasSelection()) {
                    var record = selModel.getSelected();
                    Ext.MessageBox.confirm('Confirmación', '¿Está seguro de eliminar este registro?', function(btn) {
                        if (btn === 'yes') {
                            Ext.Ajax.request({
                                url: '../servicesAjax/eliminarPersonal.php',
                                params: { COD_PERSONAL: record.get('COD_PERSONAL') },
                                success: function(response) {
                                    Ext.namespace.storePersonal.reload();
                                    Ext.MessageBox.alert('Éxito', 'Registro eliminado correctamente.');
                                },
                                failure: function() {
                                    Ext.MessageBox.alert('Error', 'No se pudo eliminar el registro.');
                                }
                            });
                        }
                    });
                } else {
                    Ext.MessageBox.alert('Advertencia', 'Seleccione un registro para eliminar.');
                }
            }
        },
        '->', // Alinea el combo y el campo a la derecha
        estadoCombo,
        searchField
    ],
    listeners: {
        rowdblclick: function(grid, rowIndex) {
            var record = grid.getStore().getAt(rowIndex); // Obtener el registro seleccionado
            abrirFormularioPersonal('modificar', record); // Abrir el formulario en modo modificar
        }
    }
});


    // Renderización de la ventana principal
    new Ext.Viewport({
        layout: 'border',
        items: [personalGrid]
    });

    // Cargar datos al cargar la página
    Ext.namespace.storePersonal.load({ params: { start: 0, limit: 50, activo: 1, inactivo: 0 } });
});
