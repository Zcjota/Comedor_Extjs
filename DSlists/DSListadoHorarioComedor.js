/*!
 * DSoft-TPMV
 * Copyright(c) 2012
 */
Ext.onReady(function(){
	Ext.namespace('Ext.dsdata');

	Ext.dsdata.storeHorario_Comedor = new Ext.data.JsonStore({  	
		url: '../servicesAjax/DSListadoComedorHorarioAjax.php',  
		root: 'data',   
		totalProperty: 'total',
		fields: ['codigo', 'descripcion','horario','horario_fin']		
	}); 
	var indice=-1;
	var Paginas = new Ext.PagingToolbar({
		pageSize: 25, 
		store: Ext.dsdata.storeHorario_Comedor,
		displayInfo: true,
		afterPageText: 'de {0}',
		beforePageText: 'Pag.',
		firstText: 'Primera Pag.', 
		lastText: 'Ultima Pag.',
		nextText: 'Siguiente Pag.',
		prevText: 'Pag. Previa',
		refreshText: 'Refrescar',	
		displayMsg: 'Desplegando del {0} - {1} de {2}',
		emptyMsg: "No hay elementos para desplegar."
	});
	
	var Columnas = new Ext.grid.ColumnModel(  
		[{  
			header: 'codigo',  
			dataIndex: 'codigo',  
			align: 'right',
			hidden :true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Descripcion</a>', 
			dataIndex: 'descripcion',  
			renderer: formato, 
			width: 200,
			align: 'left',
			sortable: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Hora Inicio</a>', 
			dataIndex: 'horario',  
			renderer: formato, 
			width: 100,
			align: 'left',
			sortable: true
		}	
		,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Hora Fin</a>', 
			dataIndex: 'horario_fin',  
			renderer: formato, 
			width: 100,
			align: 'left',
			sortable: true
		}		
		]  
	);	
	function formato(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}
	var grid = new Ext.grid.GridPanel({  
		id: 'gridHorarioComedor',
		store: Ext.dsdata.storeHorario_Comedor, 
		region:'center',
		cm: Columnas, 
		enableColLock:false,
		stripeRows: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		bbar: Paginas, 
		listeners:{			
			render:function(){
				Ext.dsdata.storeHorario_Comedor.load({params:{start:0,limit:25}});	
			},
			'celldblclick' :function()
			{	
				modHorario(indice);
			}
		},
		sm: new Ext.grid.RowSelectionModel({
				singleSelect: true,
				listeners: {					
						rowselect: function(sm, row, rec)
						{  
							indice = row;
							//var RegistoMod = Ext.namespace.storeTramite.getAt(Indicev).get('numerotramite'); ASI SE LO LLAMA											
						}      
					}
		})		
	});	

	var filter = new Ext.form.TextField({name: 'filterValue',cls: 'namelabel',
	style : {textTransform: "uppercase"}
	
	});	
	var bfilter = new Ext.Toolbar.Button({
		text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Buscar</a>',
		tooltip: "Utilizar '*' para busquedas ",  
		icon: '../img/view.png',
		handler: function(btn,e) {					
			var filterVal = filter.getValue();
			if( filterVal.length > 0 ) 
			{  
				var o = {start : 0, limit:25};					
				Ext.dsdata.storeHorario_Comedor.baseParams['buscar'] = filterVal;
				Ext.dsdata.storeHorario_Comedor.reload({params:o});
			} 
			else {
				Ext.dsdata.storeHorario_Comedor.clearFilter();
			}	
		}
	});

	function eliminar_HorarioComedor(indice)
	{
        cod = Ext.dsdata.storeHorario_Comedor.getAt(indice).get('codigo'); 
		Ext.Ajax.request({  
		url: '../servicesAjax/DSdesactivarHorarioComedorAJAX.php',  
		method: 'POST',  
		params: {id:cod},  
		success: desactivo,  
		failure: no_desactivo  
		});  

		function desactivo(resp)  
		{  	
			Ext.MessageBox.alert('Mensaje', 'Eliminado');  			
			Ext.dsdata.storeHorario_Comedor.load({params:{start:0,limit:25}});
		}  
  
		function no_desactivo(resp)  
		{  			
			Ext.MessageBox.alert('Mensaje', resp.mensaje);  
		}  
        }	
		
	var PAmenu = new Ext.Panel({
		region: 'north',
		id: 'PAmenuPr',
		height: 29,   
		tbar: [{
				xtype: 'buttongroup',
				items: [{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nuevo</a>',
							icon: '../img/Nuevo.png',
							handler: function(t){
								NuevoHorarioComedor();						  				
							}
						},{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Modificar</a>',
							icon: '../img/Editar.png',
							handler: function(t)
							{
								if(indice!=-1)
								{
								modHorario(indice);}
								else{Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Seleccione uno de la Lista</a>'); }
								
							}
						},{
							text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Eliminar</a>',
							icon: '../img/Eliminar.png',
							handler: function confirm()
							{
								if(indice!=-1)
								{
									return Ext.MessageBox.confirm('confirmar','desea eliminar_HorarioComedor este registro?',
										function(s){
											if(s=='yes'){
												eliminar_HorarioComedor(indice);
											
											
										}}
									)
								}
								else	{ 
								Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"> Seleccione uno de la Lista</a>'); 
								}	
							
																				
							}
						}
						]
			},
			 '->', filter, bfilter								
			]
	});	
	
	var viewport1 = new Ext.Viewport({
		layout: 'border',
		items: [PAmenu, grid]		
	}); 
});