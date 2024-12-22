	var winDocumento;		
		var codigo;
		var opcion;// = 1; //1=alta; 2= modificar
	var txtNombreDoc = new Ext.form.TextField(
	{
		name: 'txtNombreDoc',
		hideLabel: true,		
		width: 250,
		x: 130,
		y: 10,
		allowBlank: false,
		maxLength : 100,
		style : {textTransform: "uppercase"},
		blankText: 'Nombre requerido',				
		enableKeyEvents: true,
		selectOnFocus: true,
		cls:'name',
		listeners: 
		{
			keypress: function(t,e){
				if(e.getKey()==13){
					cboExtension.focus();
				}
			}
		}
	});

     var fichero = new Ext.form.FileUploadField(
		{  
            x : 500,
			y : 10,
            emptyText: 'SELECCIONAR ARCHIVO',            
            name: 'archivo',            
            width: 250,  
			allowBlank: false,
			cls: 'name',
            buttonCfg: {  
                text: '',  
                iconCls: 'upload-icon'  
            },
			listeners:
			{
				'fileselected': function(fb, v)
				{
					dire = v;
				}
			}		
		});
		
			// Labels
	
	var lblNombre = new Ext.form.Label({
		text: 'NOMBRE DOCUMENTO:',
		x: 10,
		y: 15,
		height: 20,
		cls: 'namelabel'
	});

	var lbldocumento = new Ext.form.Label({
		text: 'DOCUMENTO :',
		x: 420,
		y: 15,
		height: 20,
		cls: 'namelabel'
	});
	
	var btnAceptarDoc = new Ext.Button({
		id: 'btnAceptarDoc',
		x: 250,
		y: 40,
		text: 'Aceptar',
		icon: '../img/save.png',
		iconCls: 'x-btn-text-icon',
		minWidth: 80,
		handler:function(){
			frmDocumento.validarAcceso();				
		} 
	});
			
	var btnLimpiarDoc = new Ext.Button({
		id: 'btnLimpiarDoc',
		x: 350,
		y: 40,
		text: 'Cancelar',
		icon: '../img/delete.png',
		iconCls: 'x-btn-text-icon',
		minWidth: 80,
		handler:function()
		{				
			var frm = frmDocumento.getForm();
			frm.reset();
			frm.clearInvalid();
			winDocumento.hide();
		} 
	});
	
	var rowIndex_doc=-1;
	var sm_d = new Ext.grid.CheckboxSelectionModel({
		singleSelect: true,
		listeners: {
			rowselect: function (sm, row, rec) {
				rowIndex_doc = row;
			}, // para cuando deselecciona el check del grid
			rowdeselect: function (sm, row, rec) {
				rowIndex_doc = 'e';
			}
		}
	});
	
	storedocumento = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSListaDocumentosPersonal.php',   
		root: 'data',   
		totalProperty: 'total', 	 
		fields: ['codigo','nombre_documento','extension','fecha']  ,
		listeners: { 		       
					load: function(thisStore, record, ids) 
					{ 
						
						
					}
		}
		
	});  
	
		var Columnas_doc = new Ext.grid.ColumnModel(  
		[
			sm_d,	
		{  
			header: 'Codigo',  
			dataIndex: 'codigo',                
			hidden: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
			dataIndex: '',
			width:25,				
			renderer: function(value, cell){  
				
				str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/descarga3.jpg' WIDTH='17' HEIGHT='15'></div>";    
				return str; 
				
				
				 
			}
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
			dataIndex: '',
			width:25,				
			renderer: function(value, cell){  
				
				str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/Eliminar.png' WIDTH='13' HEIGHT='13'></div>";    
				return str; 
				
				
				 
			}
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Formato</a>', 
			dataIndex: 'extension',
			width:70
		},
		{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Documento</a>',
			dataIndex: 'nombre_documento',  
			width:250,
			sortable: true
		}
		,
		{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Fecha Alta</a>',
			dataIndex: 'fecha',  
	
			width:120,
			sortable: true
		}
		
		]  
		);
		var GridDocumento = new Ext.grid.EditorGridPanel({  
			id: 'GridDocumento',			
			y:75,
			x:15,
			width :700,	
			height : 500,
			store: storedocumento,	
			autoScroll:true,			
			cm: Columnas_doc, 			
			border: false,   
			enableColLock:false,
			stripeRows: false,				
			deferRowRender: false,
			sm: sm_d,
			destroy : function () {
				if (this.store) {
					this.store.destroyStore();
				}
				this.callParent();
			},
			listeners: 
			{
				
				'cellclick' : function(grid, rowIndex, cellIndex, e){
					var store = grid.getStore().getAt(rowIndex);
					var columnName = grid.getColumnModel().getDataIndex(cellIndex);
					var cellValue = store.get(columnName);
					arch="../DocumentacionPersonal/"+storedocumento.getAt(rowIndex).get('codigo')+"."+storedocumento.getAt(rowIndex).get('extension');
					
					if(cellIndex==3)
					{
					return Ext.MessageBox.confirm('confirmar','desea eliminar este registro?',
										function(s){
											if(s=='yes'){
												eliminarDoc(storedocumento.getAt(rowIndex).get('codigo'));
											
											//Ext.dsdata.storedatospersonal.load({params:{start:0,limit:25}});
										}}
									)
					}
					if(cellIndex==2)
					{
						
						ExportarDoc(arch); 

					}
				
				}
			},
		});
		function eliminarDoc(indice)
		{
			cod = indice; 
			Ext.Ajax.request({  
			url: '../servicesAjax/DSdesactivarDocumentoPersonalAJAX.php',  
			method: 'POST',  
			params: {id:cod},  
			success: desactivo,  
			failure: no_desactivo  
			});  

			function desactivo(resp)  
			{  	
				Ext.MessageBox.alert('Mensaje', 'Eliminado');  			
				txtNombreDoc.focus(true, 100);
				storedocumento.load({params:{codigo: codigo}});
			}  
	
			function no_desactivo(resp)  
			{  			
				Ext.MessageBox.alert('Mensaje', resp.mensaje);  
			}  
		}	
		function ExportarDoc(arch)
		{
			
			var pagina = "../servicesAjax/Descargar.php?arch="+ arch;
			var opciones = "toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=yes, width=1000, height=800, top=0, left=0";
			window.open(pagina,"",opciones); 

		}			
	var frmDocumento = new Ext.FormPanel(
	{ 
		fileUpload: true,
		frame:true, 		
		layout: 'absolute',
		autoScroll:true,
		items:[
			 lblNombre,lbldocumento,
				txtNombreDoc,fichero,
				btnAceptarDoc, btnLimpiarDoc,GridDocumento
			  ],
		validarAcceso: function()
		{	if (this.getForm().isValid()) 
			{	this.getForm().submit(
				{	url: '../servicesAjax/DSabmdocumentoPersonalAJAX.php', 
					params: {codigo: codigo, opcion:opcion},
					method: 'POST',
					waitTitle: 'Conectando',
					waitMsg: 'Enviando Datos...',
					success: function(form, action)
					{
						txtNombreDoc.setValue(""); 
						fichero.setValue("");
						txtNombreDoc.focus(true, 100);
						storedocumento.load({params:{codigo: codigo}});
						
										
					},					
					failure: function(form, action)
					{if (action.failureType == 'server') 
						{	var data = Ext.util.JSON.decode(action.response.responseText);
							Ext.Msg.alert('BUGS', data.errors.reason, function()
							{
								txtNombreDoc.focus(true, 100);
							});
						}
						else 
						{
							Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
						}
						
					}
				});
			}
		}
	});
			
	function AltaDocumento(idpersonal,nombrep)
	{		
			winDocumento = new Ext.Window(
			{
				layout: 'fit',
				width: 450,
				height: 230,		
				title: 'DOCUMENTO DE '+nombrep,			
				resizable: false,
				closeAction: 'hide',
				closable: true,
				draggable: false,
				plain: true,
				border: false,
				modal: true,
				maximized: true,					
				items: [frmDocumento],
				listeners: {	
					'hide': function ()
					{
						var frm = frmDocumento.getForm();
						frm.reset();
						frm.clearInvalid();
					},											
					show: function()
					{
						txtNombreDoc.focus(true, 100);
						storedocumento.load({params:{codigo: idpersonal}});
						
											
					}
				}
			});
		codigo=idpersonal;
		
		txtNombreDoc.setValue(""); 
		fichero.setValue("");
		opcion = 0;
		
		winDocumento.show();
			
	}
			