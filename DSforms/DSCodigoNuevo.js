
var winCodigo;
Ext.apply(Ext.form.VTypes, {
    validacionNumero: function (value, field) {
        return /[0-9]/.test(value);
    },
    validacionNumeroText: 'Los datos ingresado no son válidos. Solo números',
    validacionNumeroMask: /[0-9]/i
});
Ext.form.NumberField.override ({
     /*
      * @cfg {Boolean} true forces the field to show following zeroes. e.g.: 20.00
      */
     forceDecimalPrecision : false
     
    ,fixPrecision : function(value){
        var nan = isNaN(value);
        if(!this.allowDecimals || this.decimalPrecision == -1 || nan || !value){
           return nan ? '' : value;
        }
        value = parseFloat(value).toFixed(this.decimalPrecision);
        if(this.forceDecimalPrecision)return value
        return parseFloat(value);
    }
    ,setValue : function(v){
        if(!Ext.isEmpty(v)){
            if(typeof v != 'number'){
                if(this.forceDecimalPrecision){
                    v = parseFloat(String(v).replace(this.decimalSeparator, ".")).toFixed(this.decimalPrecision);
                } else {
                    v = parseFloat(String(v).replace(this.decimalSeparator, "."));
                }
            }
            v = isNaN(v) ? '' : String(v).replace(".", this.decimalSeparator);
        }
        return Ext.form.NumberField.superclass.setValue.call(this, v);
    }
});
var id_personal;
var txtNombreCodigo = new Ext.form.TextField({
    id: 'txtNombreCodigo',
    name: 'txtNombreCodigo',
    anchor: '80%',
    fieldLabel: 'Nombre',
    style: {textTransform: "uppercase"},
	readOnly:true,
    allowBlank: false,
    maxLength: 100,
    enableKeyEvents: true,
    selectOnFocus: true,
	cls:"fondoPlomo",
    listeners: {
        'keypress': function (e)
        {
        }
    }
});

var txtCodigoActual = new Ext.form.NumberField({
    fieldLabel: 'Código Actual',
    id: 'txtCodigoActual',
    name: 'txtCodigoActual',
    anchor: '80%',
    allowBlank: false,
	readOnly:true,
    maxLength: 90,
    enableKeyEvents: true,
    selectOnFocus: true,
	cls:"fondoPlomo",
    listeners: {
        'keypress': function (e) {
          
        }
    }
});
var txtCodigoAnteriores= new Ext.form.NumberField({
    fieldLabel: 'Código Anterior',
    id: 'txtCodigoAnteriores',
    name: 'txtCodigoAnteriores',
    anchor: '80%',
    allowBlank: false,
    maxLength: 90,
    enableKeyEvents: true,
    selectOnFocus: true,
	cls:"name",
    listeners: {
        'keypress': function (e) {
          
        }
    }
});


var storeHistoricoCodigo = new Ext.data.JsonStore(
		{
				url: '../servicesAjax/DSGrillaHistoricoCodigo.php',
				root: 'data',			
				totalProperty: 'total',
				fields: ['codigo'],
				listeners: { 
			
				}	      
				
		});
	function formatocodigo(value, metadata, record, rowIndex, colIndex, store) {  
				metadata.attr = 'style="white-space:normal;font-size:10px;"';      
				 return value; 
	}
var smcodigo = new Ext.grid.CheckboxSelectionModel(
		);
		var ColumnasCodigo = new Ext.grid.ColumnModel(  
		[smcodigo,
			{  
				header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Código Trabajador</a>', 
				dataIndex: 'codigo', 			
				width : 150,
				renderer: formatocodigo
			}
					
		]  
        );
	var grid_Historico_Codigo = new Ext.grid.EditorGridPanel({  
			id: 'grid_Historico_Codigo',			
			height:120,
			width : 450,
			x: 110,
			y: 230,
			store: storeHistoricoCodigo,		
			cm: ColumnasCodigo, 			
			border: false,   
			enableColLock:false,
			stripeRows: true,				
			deferRowRender: false,
			sm: smcodigo,
			destroy : function () {
				if (this.store) {
					this.store.destroyStore();
				}
				this.callParent();
			},
		});
function buscarItemRepetido(coditem){ 
			
			var cantida = 0;
			storeHistoricoCodigo.each(function(record){
				if(record.data.codigo == coditem)
					cantida = 1;
				
			});
			return cantida;
}
var btnAceptarCodigo = new Ext.Button(
        {
            id: 'btnAceptarCodigo',
            x: 220,
            y: 285,
			icon: '../img/save.png',
            text: 'Guardar',
            style: 'background-color: #92c95d;',
            minWidth: 80,
            handler: function ()
            {
				if(buscarItemRepetido(txtCodigoAnteriores.getValue())==0)
				{
					frmCodigo.Insertar();
				}
				else
				{
					Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">El código ya fue asignado</a>'); 
				}
                
            }
        });
	function quitarM(registrosGridM,id_personal)
	{
		Ext.Ajax.request({  
						url: '../servicesAjax/DSquitaritemsCodigo.php',  
						method: 'POST',  
						params: {registrosGridM:registrosGridM,id_personal:id_personal},  
						success: desactivo,  
						failure: no_desactivo  
						});  
						function desactivo(resp)  
						{  	
							storeHistoricoCodigo.load({params: {idpersonal: id_personal}});
						}  
				  
						function no_desactivo(resp)  
						{  	
							
						}  
	}
 var btnEliminarCodigo = new Ext.Button(
  {
            id: 'btnEliminarCodigo',
            text: 'Eliminar',
            style: 'background-color: #92c95d;',
			icon: '../img/Eliminar.png',
            minWidth: 80,
            'handler': function ()
            {
                var i=0;
				var datosGrid = [];  
				smcodigo.each(function(rec){         
					i++;
					datosGrid.push(Ext.apply({id:rec.id},rec.data));            
				});    	
				if(i>0){	
					registrosGridM = Ext.encode(datosGrid); 	
					quitarM(registrosGridM,id_personal);
				}
				else
				{
					Ext.MessageBox.show({
							title: 'MENSAJE',
							msg: 'Seleccione uno de la lista.',
							buttons: Ext.MessageBox.OK,
							selectOnFocus: true,
							icon: Ext.MessageBox.INFO
						});
				
				
				}
            }
  });

var btnLimpiarCodigo = new Ext.Button(
        {
            id: 'btnLimpiarCodigo',
            text: 'Cancelar',
            style: 'background-color: #92c95d;',
			icon: '../img/delete.png',
            minWidth: 80,
            'handler': function ()
            {
                var frmA = frmCodigo.getForm();
                frmA.reset();
                frmA.clearInvalid();
                winCodigo.hide();
            }
        });

var frmCodigo = new Ext.FormPanel(
        {
            labelAlign: 'left',
            id: 'formRRHHED',
            frame: true,
            layout: 'form',
            bodyStyle: 'padding:5px;',
            waitMsgTarget: true,
            items: [txtNombreCodigo,txtCodigoActual,txtCodigoAnteriores,
				grid_Historico_Codigo

            ],
            Insertar: function ()
            {
                if (this.getForm().isValid())
                {
							uri = '../servicesAjax/DSabmhistoricoCodigoAjax.php';
							this.getForm().submit(
									{
										url: uri,
										params: {id_personal: id_personal},
										method: 'POST',
										waitTitle: 'Conectando',
										waitMsg: 'Enviando Datos...',
										success: function (form, action)
										{
											var data = Ext.util.JSON.decode(action.response.responseText);
											Ext.Msg.alert('MENSAJE', data.msg.reason);
											storeHistoricoCodigo.load({params: {idpersonal: id_personal}});
											txtCodigoAnteriores.setValue("");
										},
										failure: function (form, action)
										{
											if (action.failureType === 'server')
											{
												var data = Ext.util.JSON.decode(action.response.responseText);
												Ext.Msg.alert('ERROR', data.errors.reason, function ()
												{

												});
											}
											else
											{
												Ext.Msg.alert('ERROR', 'Imposible conectar con servidor : ' + action.response.responseText);
											}

										}
									});
					
                }
				else
				{
					Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Algunos campos son obligatorios.</a>'); 
				}
            }

        }
);
var fechaActual = new Date()
		var mes= 1+fechaActual.getMonth();
				
		var year=fechaActual.getYear();
		

		if(year<1000)
		{
		 year+=1900;
		}
		if(parseInt(mes)<10)
		{
			mes="0"+mes;
		
		}
		
		fechalimite=year+"/"+mes+"/01";
		

function CodigoNuevo(ind)
{
    if (!winCodigo)
    {
        winCodigo = new Ext.Window(
                {
                    layout: 'fit',
                    width: 450,
                    height: 300,
                    title: 'CODIGO TRABAJADOR',
                    resizable: false,
                    closeAction: 'hide',
                    closable: true,
                    draggable: false,
                    plain: true,
                    border: false,
                    modal: true,
                    items: [frmCodigo],
					buttonAlign:'center',
					buttons:[btnAceptarCodigo,btnEliminarCodigo, btnLimpiarCodigo],
                    listeners:
                            {
                                'hide': function ()
                                {
                                    var frm = frmCodigo.getForm();
                                    frm.reset();
                                    frm.clearInvalid();
                                },
                                'show': function ()
                                {
                                }
                            }
                });
    }
	
	id_personal= Ext.dsdata.storedatospersonal.getAt(ind).get('codigo');
	txtNombreCodigo.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('nombre'));
	txtCodigoActual.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cod_trabajador'));
	storeHistoricoCodigo.load({params: {idpersonal: id_personal}});
    winCodigo.show();
}






