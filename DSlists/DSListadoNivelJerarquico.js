
Ext.onReady(function(){
	Ext.namespace('Ext.dsdata');

	Ext.dsdata.storeNivelJerarquico = new Ext.data.JsonStore({  	
		url: '../servicesAjax/DSListadoNivelJerarquico.php',  
		root: 'data',   
		totalProperty: 'total',
		fields: ['COD_NIVEL', 'NOMBRE_NIVEL','CATEGORIA','ochenta','noventa','midpoint','ciento_diez','ciento_veinte']		
	}); 
	var indice=-1;
	var Paginas = new Ext.PagingToolbar({
		pageSize: 25, 
		store: Ext.dsdata.storeNivelJerarquico,
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
	var sm2 = new Ext.grid.CheckboxSelectionModel({
        listeners: {rowselect: function (sm, row, rec){indice = row;}}
    });
	var Columnas = new Ext.grid.ColumnModel(  
		[new Ext.grid.RowNumberer({width: 23}), sm2,{  
			header: 'codigo',  
			dataIndex: 'COD_NIVEL',  
			align: 'right',
			hidden :true
		},{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Categoria</a>', 
			dataIndex: 'CATEGORIA',  
			renderer: formato, 
			width: 250,
			align: 'left',
			sortable: true
		}
		,{  
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nivel</a>', 
			dataIndex: 'NOMBRE_NIVEL',  
			renderer: formato, 
			width: 60,
			align: 'center',
			sortable: true
		}
		,{  
			format:'0,0',
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">80%</a>', 
			xtype: 'numbercolumn',
			dataIndex: 'ochenta',  
			renderer: formato, 
			width: 70,
			align: 'right',
			sortable: true
		}
		,{  
			format:'0,0',
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">90%</a>', 
			xtype: 'numbercolumn',
			dataIndex: 'noventa',  
			renderer: formato, 
			width: 70,
			align: 'right',
			sortable: true
		},{  
			format:'0,0',
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Midpoint</a>', 
			xtype: 'numbercolumn',
			dataIndex: 'midpoint',  
			renderer: formato, 
			width: 80,
			align: 'right',
			sortable: true
		},{  
			format:'0,0',
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">110%</a>', 
			xtype: 'numbercolumn',
			dataIndex: 'ciento_diez',  
			renderer: formato, 
			width: 70,
			align: 'right',
			sortable: true
		}
		,{  
			format:'0,0',
			header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">120%</a>', 
			xtype: 'numbercolumn',
			dataIndex: 'ciento_veinte',  
			renderer: formato, 
			width: 70,
			align: 'right',
			sortable: true
		}
		]  
	);	
	function formato(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}
	var grid = new Ext.grid.GridPanel({  
		id: 'gridNivel',
		store: Ext.dsdata.storeNivelJerarquico, 
		region:'center',
		cm: Columnas, 
		columnLines: true,
		enableColLock:false,
		stripeRows: false,
		selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
		bbar: Paginas, 
		listeners:{			
			render:function(){
				Ext.dsdata.storeNivelJerarquico.load({params:{start:0,limit:25}});	
			},
			'celldblclick' :function()
			{	
				modNivel(indice);
			}
		},
		sm: sm2
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
				Ext.dsdata.storeNivelJerarquico.baseParams['buscar'] = filterVal;
				Ext.dsdata.storeNivelJerarquico.reload({params:o});
			} 
			else {
				Ext.dsdata.storeNivelJerarquico.clearFilter();
			}	
		}
	});

	function eliminar(indice)
	{
		Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
        cod = Ext.dsdata.storeNivelJerarquico.getAt(indice).get('COD_NIVEL'); 
		Ext.Ajax.request({  
		url: '../servicesAjax/DSdesactivarNivelAJAX.php',  
		method: 'POST',  
		params: {id:cod},  
		success: desactivo,  
		failure: no_desactivo  
		});  

		function desactivo(resp)  
		{  	
			Ext.Msg.hide();
			Ext.MessageBox.alert('Mensaje', 'Eliminado');  
						
			Ext.dsdata.storeNivelJerarquico.load({params:{start:0,limit:25}});
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
								NuevaNivel();						  				
							}
						},{
							text:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Modificar</a>',
							icon: '../img/Editar.png',
							handler: function(t)
							{
								if(indice!=-1)
								{
									modNivel(indice);
								}
								else{Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Seleccione uno de la Lista</a>'); }
								
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
												eliminar(indice);
											
											
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