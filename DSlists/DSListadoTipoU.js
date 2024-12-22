	Ext.onReady(function()
	{
		Ext.namespace('Ext.dsdata');
		//muestra el listado tras que comienza
		Ext.dsdata.frmTipoU = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSlistaTipoUAjax.php',   
		root: 'data',   
		totalProperty: 'total',
		fields: ['codigo','nombre']
		});  		
		var indice = 'ee';
		
		var Paginas = new Ext.PagingToolbar({ //toolbar
			pageSize: 25,  
			store: Ext.dsdata.frmTipoU,  
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

		var Columnas = new Ext.grid.ColumnModel(  //nombre de las columnas para la grilla
            [{  
                header: 'Codigo',  
                dataIndex: 'codigo',                
                hidden: true
            },
			{  
                header: 'Nombre',  
                dataIndex: 'nombre',  
                width: 180,
                sortable: true
            }	
			]  
        );	 		
		
		var grid = new Ext.grid.EditorGridPanel({  //?
			id: 'gridTipoU',
			store: Ext.dsdata.frmTipoU, 
			region:'center',
			cm: Columnas,			
			enableColLock:false, 
			selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
			border: false,   
			stripeRows: true,
			bbar: Paginas, 
			listeners:
			{
				render:function()
				{
					Ext.dsdata.frmTipoU.load({params:{start:0,limit:25}});					
				},
				'celldblclick' :function()
				{
						if(indice == 'ee')
							{
								alert('Seleccione un registro PorFavor');
							}
							else{modTipoU(indice);}						
				}
			},
			sm: new Ext.grid.RowSelectionModel( //selecciona un dato en la  grilla para eliminar o actualizar
			{
                singleSelect: true,
                listeners: 
				{
					rowselect: function(sm, row, rec) 
					{                        
						indice = row;													
                    }
                }
            })			
		});
		
		function eliminar(idSel){ //para eliminar el dato seleccionado

			Ext.Ajax.request({  
            url: '../servicesAjax/DSdesactivarTipoUAJAX.php',  
            method: 'POST',  
            params: {codigo:idSel},  
            success: desactivo,  
            failure: no_desactivo  
			});  
  
			function desactivo(resp)  
			{  		
				Ext.dsdata.frmTipoU.load({params:{start:0, limit:25}});	
			}  
      
			function no_desactivo(resp)  
			{  			
				Ext.MessageBox.alert('Mensaje', resp.mensaje);  
			}  
        }				
		
		var filter = new Ext.form.TextField({name: 'filterValue'});

		var bfilter = new Ext.Toolbar.Button( // para buscar un dato
		{
			text: 'Buscar',
			tooltip: "Utilizar '*' para busquedas ",            
			icon: '../img/view.png',
			handler: function(btn,e) 
			{
				var filterVal = filter.getValue();
				if( filterVal.length > 0 ) 
				{
					var o = {start : 0, limit:25};					
					Ext.dsdata.frmTipoU.baseParams['buscar'] = filterVal;
					Ext.dsdata.frmTipoU.reload({params:o});
				}
				else 
				{
					Ext.dsdata.frmTipoU.clearFilter();
				}
			}
		});
		
		var PAmenu = new Ext.Panel( //menu para los abm
		{
			region: 'north',
			id: 'PAcabecera1',
			height: 29,   
			tbar: [
					{
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nuevo</a>',
						icon: '../img/Nuevo.png',
						handler: function(t)
						{
							altaTipoU();						
						}
					},
					{
						xtype: 'tbseparator'
					},
					{
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Modificar</a>',
						icon: '../img/Editar.png',
						handler: function(t)
						{
							if(indice == 'ee')
							{
								alert('Seleccione un registro PorFavor');
							}
							else{modTipoU(indice);}						
						}
					},
					{
						xtype: 'tbseparator'
					},
					{
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Eliminar</a>',
						icon: '../img/Eliminar.png',
						handler: function confirm()
						{					
							return Ext.MessageBox.confirm('Confirmar','Desea eliminar este registro?', 
								function(s){
									if(s=='yes'){
										eliminar(Ext.dsdata.frmTipoU.getAt(indice).get('codigo'));
									}	
							}
							)
						}
					},
					{
						xtype: 'tbseparator'
					},
					{
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Roles y Permisos</a>',
						icon: '../img/check.png',
						handler: function(t)
						{		
							if(indice == 'ee')
							{
								alert('Seleccione un registro PorFavor');
							}
							else{PermisoUsuario(Ext.dsdata.frmTipoU.getAt(indice).get('codigo'));}		
							
						}
					},	'->', filter, bfilter																
				]
			});				
					
		var viewport1 = new Ext.Viewport(
		{
			layout: 'border',
			items: [ PAmenu, grid]
		}); 
	});
        