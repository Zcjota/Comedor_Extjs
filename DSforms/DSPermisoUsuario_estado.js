	var winPermisoUsuario_estado;
	
		var txtCodUsuario_esta = new Ext.form.TextField({
			name: 'codusuario', 
			hideLabel: true,
			hidden: true,
            maxLength : 10,	
			width:80,
			y :45,
			x: 100							
		});	
	
		storePermisosUsuario_permiso = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSListaUsuario_estadoGRAJAX.php',   
		root: 'data',   
		//totalProperty: 'total',
		
		fields: ['codigoes','nombrees','ticket'],
		listeners:{  
					 load: function(thisStore, record, ids) {  					
						var pos=0;  
						var miArray = new Array();  
						for(i=0; i<this.getCount();i++){  
							if(parseInt(record[i].data.ticket) == 1){  
								miArray[pos]=i;  
								pos++;  
							}  
						}  			
						Gridus.getSelectionModel().selectRows(miArray, true);	
					 }
			}
 		});  
			
		
		
		var smus = new Ext.grid.CheckboxSelectionModel();

		var ColumnasUS = new Ext.grid.ColumnModel(  
            [
			{                  
                header: 'codigo',  
                dataIndex: 'codigoes',  
                hidden :true				
            },{  
                header: 'Estado',  
                dataIndex: 'nombrees',  
                width: 300,
                sortable: true            
            },
			smus
			]  
        );	

			
		
		var Gridus = new Ext.grid.EditorGridPanel({  
			id: 'gridPermiso',
			x : 10,
			y : 10,
			width : 345,	
			height : 200,
			sm : smus,
			store: storePermisosUsuario_permiso,//storeDocumentos.load({ params:{patron: cboPatron.getValue()} });		
			cm: ColumnasUS, 	
			selModel: new Ext.grid.RowSelectionModel({multipleSelect:true}),
			border: false,   
			enableColLock:false,
			stripeRows: true,
			clicksToEdit: 1
		});			

		var btnAceptarUS = new Ext.Button({
		    id: 'btnAceptar',
			x: 80,
			y: 220,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				GuardarArrayUS();
				frmPermiso_usuario.guardarDatosUS();
			} 
		});
		
		var btnLimpiarUS = new Ext.Button({
		    id: 'btnLimpiar',
			x: 175,
			y: 220,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmPermiso_usuario.getForm().reset;					
				winPermisoUsuario_estado.hide();
			} 
		});	

		

		function GuardarArrayUS() {  
			var keys = Gridus.selModel.selections.keys;  
			var datosGridUS = [];  
			smus.each(function(rec){                                                       
				datosGridUS.push(Ext.apply({id:rec.id},rec.data));            
   			});    	

			this.Gridus.stopEditing();    
			registrosGridUS = Ext.encode(datosGridUS); 
					
		}; 	
		
		
		var frmPermiso_usuario = new Ext.FormPanel({ 
			frame:true, 
			selectOnFocus: true,
			layout: 'absolute',
			items:[txtCodUsuario_esta, Gridus, btnAceptarUS, btnLimpiarUS],
			guardarDatosUS: function(){
				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSguardarPermisosUsuario_estadoAJAX.php',
						params :{registrosUS : registrosGridUS },  
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando Datos...',
						success: function(form, action){	
						//		frmPermiso_usuario.getForm().reset;	
								winPermisoUsuario_estado.hide();	
								//Ext.dsdata.storeListadoAduanas.load({params:{start:0,limit:25}});									
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									//txtNumero.focus(true, 100);
								});
							}
							else {
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}						
						}
					});
				}
			}
		});		
		
		
	
		function PermisoUsuario_estado(Codigov)
		{		
			if (!winPermisoUsuario_estado) 
			{
				winPermisoUsuario_estado = new Ext.Window(
				{
					layout: 'fit',
					width: 390,
					height: 290,		
					title: 'Registro de Usuario Estado',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,					
					items: [frmPermiso_usuario],
					listeners: {					
						show: function(){
							//txtNumero.focus(true, 300);
						}
					}
				});			
			}	
			
			txtCodUsuario_esta.setValue(Codigov);			
			storePermisosUsuario_permiso.load({params:{codusuario:Codigov}});
			winPermisoUsuario_estado.show();				
		}
		
















