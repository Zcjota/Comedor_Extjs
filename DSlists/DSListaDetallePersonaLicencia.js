/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */

	Ext.namespace('Ext.dsdata');	  

	var winDetalleLicencia;	
	var dia1;
	var mes1;
	var anio1;
	var rowIndex;
		Ext.dsdata.storeLicDetalle = new Ext.data.JsonStore(
		{
			url: '../servicesAjax/DSListaLicenciaPersona.php',
			root: 'data',
			totalProperty: 'total',
			fields: ['codigog', 'nombreg', 'codhorario', 'nombreh']			
		});			

		var ColumnaLiceDetalle = new Ext.grid.ColumnModel(  
		[			
			{  
				header: 'Nombre',  
				dataIndex: 'nombreg',  									
				width : 200,
				hidden: true
			},{  
				header: 'Tipo Licencia',  
				dataIndex: 'nombreh',  								
				width : 150		
			}
		]  
        );	
		
		var gridDetalleLic = new Ext.grid.EditorGridPanel({  
			id: 'servLic',			
			height: 270,
			width : 430,
			x : 0,
			y : 0,
			store: Ext.dsdata.storeLicDetalle,		
			cm: ColumnaLiceDetalle,
			single: true,
			sm: new Ext.grid.RowSelectionModel(
						{
							singleSelect: true,
							listeners: 
							{
								rowselect: function(sm, row, rec) 
								{                        
									rowIndex = row;	
									// alert(rowIndex);
										
								}
							}
						}),			
			border: true,   
			enableColLock:false,
			stripeRows: false,				
			deferRowRender: false
		});	
		function eliminar(indice,dia1,mes1,anio1)
		{
			cod = Ext.dsdata.storeLicDetalle.getAt(indice).get('codigog'); 
			Ext.Ajax.request({  
			url: '../servicesAjax/DSdesactivarLicencia.php',  
			method: 'POST',  
			params: {id:cod,dia:dia1,mes:mes1,anio:anio1},  
			success: desactivo,  
			failure: no_desactivo  
			});  

			function desactivo(resp)  
			{  	
				//Ext.MessageBox.alert('Mensaje', 'Eliminado');  			
				storeCronoLicencia.load({params:{nuevo : 1, grupo:Ext.dsdata.storeLicDetalle.getAt(indice).get('codigog')}});
				var frm = frmServicios.getForm();
								frm.reset();
								frm.clearInvalid();
								winDetalleLicencia.hide();
								storeCronoLicencia.load({params:{nuevo : 2, mes: mes, anio: anio,grupo:g}});
			}  
	  
			function no_desactivo(resp)  
			{  			
				Ext.MessageBox.alert('Mensaje', resp.mensaje);  
			}  
        }	
		var btnEliminar = new Ext.Button({
		    id: 'btnexcel',
			x: 360,
			y: 345,
			text: 'Eliminar',
			icon: '../img/Eliminar.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){	
				eliminar(rowIndex,dia1,mes1,anio1);																
			} 
		});	
		
		

		var frmServicios = new Ext.FormPanel(
		{ 
			frame:true, 
			x : 0,
			y : 0,
			height : 495,
			width : 555,
			bodyStyle:'padding:5px 5px 0',  
			layout: 'absolute',	
			items:[gridDetalleLic]						
		});		
		var PAmenuH = new Ext.Panel(
		{
			
			height: 29,   
			//title: 'holaaaa',
			tbar: [ 
					btnEliminar
				]
		});	
		function abrirServicios(dia, mes, anio,grupo)
		{
			//alert(grupo);
			if (!winDetalleLicencia) {				
				winDetalleLicencia = new Ext.Window({
					layout: 'form',
					width: 430,
					height: 280,
					//region : 'center',
					title: 'LICENCIA',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,
					modal: true,
					al: true,					
					items: [PAmenuH,frmServicios],
					listeners: {							
						hide: function()
						{
							var frm1 = frmServicios.getForm();
								frm1.reset();
								frm1.clearInvalid();
						}						
					}
				});			
			}
			dia1 = dia;
			mes1 = mes;
			anio1 = anio;
			Ext.dsdata.storeLicDetalle.load({params:{dia: dia, mes: mes, anio:anio,grupo:grupo}});			
			winDetalleLicencia.show();
		}