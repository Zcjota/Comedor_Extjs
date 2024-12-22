/*!
 * DSoft-TPMV
 * Copyright(c) 2012
 */
Ext.onReady(function(){
	Ext.namespace('Ext.dsdata');

	Ext.dsdata.storeTarjeta = new Ext.data.JsonStore({  	
		url: '../servicesAjax/DSListadoTarjetaAjax.php',  
		root: 'data',   
		totalProperty: 'total',
		fields: ['codigo', 'descripcion','unidad','subcentro','centro','nunidad','nsubcentro','ncentro']		
	}); 
	var indice=-1;
	var Paginas_Jefe = new Ext.PagingToolbar({
		pageSize: 25, 
		store: Ext.dsdata.storeTarjeta,
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
	
	var Columnas_Tarjeta = new Ext.grid.ColumnModel(  
		[{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Codigo</a>', 
			dataIndex: 'codigo',  
			//align: 'right',
			//hidden :true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nombre</a>', 
			dataIndex: 'descripcion',  
			renderer: formato, 
			width: 300,
			align: 'left',
			sortable: true
		}
		,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Unidad</a>', 
			dataIndex: 'nunidad',  
			renderer: formato, 
			width: 150,
			align: 'left',
			sortable: true
		}
		,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Subcentro</a>', 
			dataIndex: 'nsubcentro',  
			renderer: formato, 
			width: 150,
			align: 'left',
			sortable: true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Centro</a>', 
			dataIndex: 'ncentro',  
			renderer: formato, 
			width: 150,
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
		id: 'gridTarjeta',
		store: Ext.dsdata.storeTarjeta, 
		region:'center',
		cm: Columnas_Tarjeta, 
		enableColLock:false,
		stripeRows: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		bbar: Paginas_Jefe, 
		listeners:{			
			render:function(){
				Ext.dsdata.storeTarjeta.load({params:{start:0,limit:25}});	
			},
			'celldblclick' :function()
			{	
			  modTarjeta(indice);
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
				Ext.dsdata.storeTarjeta.baseParams['buscar'] = filterVal;
				Ext.dsdata.storeTarjeta.reload({params:o});
			} 
			else {
				Ext.dsdata.storeTarjeta.clearFilter();
			}	
		}
	});

	function eliminar_tarjeta(indice)
	{
        cod = Ext.dsdata.storeTarjeta.getAt(indice).get('codigo'); 
		Ext.Ajax.request({  
		url: '../servicesAjax/DSdesactivarTarjetaAJAX.php',  
		method: 'POST',  
		params: {id:cod},  
		success: desactivo,  
		failure: no_desactivo  
		});  

		function desactivo(resp)  
		{  	
			Ext.MessageBox.alert('Mensaje', 'Eliminado');  			
			Ext.dsdata.storeTarjeta.load({params:{start:0,limit:25}});
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
								NuevaTarjeta();						  				
							}
						},
						{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Modificar</a>',
							icon: '../img/Editar.png',
							handler: function(t){
								modTarjeta(indice);						  				
							}
						},{
							text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Eliminar</a>',
							icon: '../img/Eliminar.png',
							handler: function confirm()
							{
								if(indice!=-1)
								{
									return Ext.MessageBox.confirm('confirmar','desea eliminar este registro?',
										function(s){
											if(s=='yes'){
												eliminar_tarjeta(indice);
											
											
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