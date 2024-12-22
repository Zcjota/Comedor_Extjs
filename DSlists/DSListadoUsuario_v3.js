/*!
 * DSoft-TPMV
 * Copyright(c) 2011
 */

	Ext.onReady(function()
	{	
		var indice = 'e';
		Ext.namespace.storeUsuario = new Ext.data.JsonStore(
		{
			url: '../servicesAjax/DSListaUsuariosGridAJAX_v3.php',
			root: 'data',
			totalProperty: 'total',
			fields: ['codigo', 'nombre', 'apellidopaterno', 'apellidomaterno', 'usuario', 'contrasenia','correo', 'cod_tu', 'tipo_usuario', 
				'configuracion','revisor', 'emd2', 'emd', 'report2', 'report'],
			// listeners:{  
			// 	load: function(thisStore, record, ids) {  					
			// 		var pos = 0;  						
			// 		var miArray = new Array(); 						
			// 		for(i=0; i<this.getCount();i++){  
			// 			if(parseInt(record[i].data.emd2) == 1){  
			// 				miArray[pos] = i;  
			// 				pos++;  
			// 			}
			// 		}
			// 		UsuarioGrid.getSelectionModel().selectRows(miArray, true);
			// 	}
	   		// }
		});				
		var pagingAduaneroBar = new Ext.PagingToolbar(
		{
			pageSize: 500, 
			store: Ext.namespace.storeUsuario,
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
		
		// var chek = new Ext.grid.CheckboxSelectionModel(
			// {
				// multipleSelect: true,
                // listeners: 
				// {
				// 	rowselect: function(sm, row, rec) {
				// 		indice = row;
				// 		console.log(rec)
                //     }
                // },
			// 	checkOnly: true,
			// }
		// );

		var arrayEmd = [];
		var arrayReport = [];

		var aduaneroColumnMode = new Ext.grid.ColumnModel( 
			[
				{  
                     header: 'ID',  
                     dataIndex: 'codigo',  
                     width: 50,
                     sortable: true,
					 hidden: true
                },
				{  
					header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
					dataIndex: '',
					width:25,				
					renderer: function(value, cell){  
						
						str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/Editar.png' WIDTH='13' HEIGHT='13'></div>";    
						return str;
					}
				}
				,{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: '',
				width:25,				
				renderer: function(value, cell){  
					
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/Eliminar.png' WIDTH='13' HEIGHT='13'></div>";    
					return str;
				}
			},{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: '',
				width:25,
				hidden:true,
				renderer: function(value, cell){  
					
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/check.png' WIDTH='13' HEIGHT='13'></div>";    
					return str;      
				}
			},
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: '',
				width:25,	
				hidden:true,
				renderer: function(value, cell){
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/delete.png' WIDTH='13' HEIGHT='13'></div>";    
					return str;
				}
			},
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: '',
				width:25,	
				hidden:true,
				renderer: function(value, cell){
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/delete.png' WIDTH='13' HEIGHT='13'></div>";    
					return str;
				}
			},
				
				{  
                     header: 'Apellido Paterno',  
                     dataIndex: 'apellidopaterno',  
                     width: 150,
                     sortable: true
                },
				{  
                     header: 'Apellido Materno',  
                     dataIndex: 'apellidomaterno',  
                     width: 150,
                     sortable: true
                },
				{  
                     header: 'Nombre',  
                     dataIndex: 'nombre',  
                     width: 200,
                     sortable: true              
                },
				{  
                     header: 'Usuario',  
                     dataIndex: 'usuario',  
                     width: 180,
                     sortable: true
				},
				{  
                     header: 'Correo Electronico',  
                     dataIndex: 'correo',  
                     width: 200,
                     sortable: true              
                },
				{
					 header: 'IDTU',  
                     dataIndex: 'cod_tu',  
                     width: 50,
                     sortable: true,
					 hidden: true
				},
				{  
                     header: 'Tipo Usuario',  
                     dataIndex: 'tipo_usuario',  
                     width: 150,
                     sortable: true              
                },
				// {  
                //      header: 'Revisor',  
                //      dataIndex: 'revisor',  
                //      width: 150,
                //      sortable: true              
                // },
				// chek,
				/* { // TODO: 2024-03-07
					// header: '<input type="checkbox"/>', // Encabezado vacío para la segunda selección
					width: 30,
					dataIndex: 'emd2',
					renderer: function(value, metaData, record, rowIndex, colIndex, store) {
						var isChecked = record.get('emd2'); // Obtener el valor de la segunda selección
						var checkboxId = Ext.id(); // Generar un ID único para la casilla de verificación

						if(isChecked == 1) {
							arrayEmd.push(record);
						}
				
						// Agregar un evento change a la casilla de verificación
						metaData.tdAttr = 'data-qtip="Seleccionar" data-recordId="' + record.id + '"';
						metaData.tdCls = 'x-grid3-check-col';
						metaData.css += ' x-grid3-check-col-td';
						metaData.attr += ' role="presentation"';

						setTimeout(function() {
							var checkboxEl = Ext.get(checkboxId);
							checkboxEl.on('change', function() {
								if (checkboxEl.dom.checked) {
									arrayEmd.push(record);
								} else {
									arrayEmd.remove(record);
								}
							}, this);
						}, 0);
				
						return '<div style="text-align: center; vertical_align: middle;"> <input type="checkbox" id="' + checkboxId + '" ' + (isChecked == 1 ? 'checked' : '') + '/> </div>';
					}
				},
				{
					header: 'EMD',
					dataIndex: 'emd', 
					renderer: formato2,
					width: 80,
					sortable: true
				}, */
				// chek2,
				// {
				// 	// header: '<input type="checkbox"/>', // Encabezado vacío para la segunda selección
				// 	width: 30,
				// 	dataIndex: 'report2',
				// 	// renderer: function(value, metaData, record, rowIndex, colIndex, store) {
				// 	// 	var isChecked = record.get('report2');
				// 	// 	return '<input type="checkbox" ' + (isChecked == 0 ? '' : 'checked') + '/>';
				// 	// }

				// 	renderer: function(value, metaData, record, rowIndex, colIndex, store) {
				// 		var isChecked = record.get('report2'); // Obtener el valor de la segunda selección
				// 		var checkboxId = Ext.id(); // Generar un ID único para la casilla de verificación

				// 		if(isChecked == 1) {
				// 			arrayReport.push(record);
				// 		}
				
				// 		// Agregar un evento change a la casilla de verificación
				// 		metaData.tdAttr = 'data-qtip="Seleccionar" data-recordId="' + record.id + '"';
				// 		metaData.tdCls = 'x-grid3-check-col';
				// 		metaData.css += ' x-grid3-check-col-td';
				// 		metaData.attr += ' role="presentation"';

				// 		setTimeout(function() {
				// 			var checkboxEl = Ext.get(checkboxId);
				// 			checkboxEl.on('change', function() {
				// 				if (checkboxEl.dom.checked) {
				// 					arrayReport.push(record);
				// 				} else {
				// 					arrayReport.remove(record);
				// 				}
				// 			}, this);
				// 		}, 0);
				
				// 		return '<div style="text-align: center; vertical_align: middle;"> <input type="checkbox" id="' + checkboxId + '" ' + (isChecked == 1 ? 'checked' : '') + '/> </div>';
				// 	}
				// },
				// {
				// 	// header: 'MADEPAPP', // TODO: 2024-03-07 - REPORTEs
				// 	header: 'FRIDOSA',
				// 	dataIndex: 'report',
				// 	renderer: formato2,
				// 	width: 80,
				// 	sortable: true
				// }
			],
       );

	function sincronizar() {
		var arrayUsuariosEMD = [];
		let array = []

		for (let index = 0; index < arrayEmd.length; index++) {
			let val = parseInt(arrayEmd[index].data.codigo)
			array.push(val)
		}

		arrayUsuariosEMD = Ext.encode(array);

		Ext.Ajax.request({
			url: '../servicesAjax/DSBajaUsuarioEMDAJAX_v2.php',
			method: 'POST',
			params: {array: arrayUsuariosEMD},
			success: estadoEMD,
		});

		function estadoEMD(resp)  {
			Ext.MessageBox.alert('Mensaje', 'Cambios Guardados');
			Ext.namespace.storeUsuario.load({params:{start:0,limit:500}});
		}

		Ext.Ajax.request({
			// url: 'https://emd.madepa.com.bo/api/insertar',  
			url: '',  
			method: 'POST',
			params: {array: arrayUsuariosEMD},
		});

		arrayEmd = [];
	}

	function sincronizarReport() {
		var arrayUsuariosReport = []
		let array = []

		for (let index = 0; index < arrayReport.length; index++) {
			let val = parseInt(arrayReport[index].data.codigo)
			array.push(val)
		}

		arrayUsuariosReport = Ext.encode(array);

		Ext.Ajax.request({
			url: '../servicesAjax/DSBajaUsuarioReporteAJAX_v3.php',
			method: 'POST',
			params: {array: arrayUsuariosReport},
			success: estadoReport,
		});

		function estadoReport(resp)  {
			Ext.MessageBox.alert('Mensaje', 'Cambios Guardados');
			Ext.namespace.storeUsuario.load({params:{start:0,limit:500}});
		}

		Ext.Ajax.request({
			// url: 'https://apprh.madepa.com.bo/api/insertar',
			url: '',  
			method: 'POST',
			params: {array: arrayUsuariosReport},
		});

		arrayReport = [];
	}

	   function formato2(value, metadata, record, rowIndex, colIndex, store) {
			if (value == 'ACTIVO') {
				metadata.attr = 'style="background-color: #94C973; font-size:10px;"';
			} else {
				metadata.attr = 'style="background-color: #FADCD9; font-size:10px;"';
			}
			metadata.attr = String.format('{0} title="{1}"', metadata.attr, value);
			return value;
		}

		UsuarioGrid = new Ext.grid.GridPanel(
		{  
			id: 'usergrid',
			store: Ext.namespace.storeUsuario,
			loadMask: true,
			region : 'center',

			// sm: chek,
			sm: new Ext.grid.RowSelectionModel(
				{
					singleSelect: true,
					listeners: 
					{
						rowselect: function(sm, row, rec) 
						{
							indice = row;
						}
					}
				}),

			cm: aduaneroColumnMode,
			border: false,
			enableColLock: false,
			stripeRows: false,
			clicksToEdit: 1,
			deferRowRender: false,
			selModel: new Ext.grid.RowSelectionModel({ singleSelect: false }),
			enableColLock:false,
			
			bbar: pagingAduaneroBar, 				
			listeners:
			{
				render:function()
				{
					Ext.namespace.storeUsuario.load({params:{start:0,limit:500}});				
				},
				'celldblclick' :function()
				{
					ModificarUsuario(indice);
				},
				'cellclick' : function(grid, rowIndex, cellIndex, e){
					var store = grid.getStore().getAt(rowIndex);
					var columnName = grid.getColumnModel().getDataIndex(cellIndex);
					var cellValue = store.get(columnName);
					if(cellIndex==1)
					{
						ModificarUsuario(indice);
					}
					if(cellIndex==2)
					{
						if(indice != 'e')
							{
							  Ext.MessageBox.show({							   
							   title:'Adbertencia',
							   msg: 'Esta seguro que desea eliminar el registro seleccionado..?',
							   buttons: Ext.MessageBox.YESNO,				           
							   icon: Ext.MessageBox.WARNING,
							   fn:function(btn) {
										if(btn == 'yes')
										{
										Ext.Ajax.request(
											{
												url : '../servicesAjax/DSBajaUsuarioAJAX.php' , 
												params : {codigo : Ext.namespace.storeUsuario.getAt(indice).get('codigo')},
												method: 'POST', 
												success: function ( result, request ) 
												{											
													Ext.namespace.storeUsuario.load({params:{start:0,limit:500}});
												},
												failure: function ( result, request) 
												{ 
													Ext.MessageBox.alert('ERROR', result.responseText); 
												} 
											});
										}
									}
							  });
							}else{alert('Seleccione un registro por favor.....!'+ indice);}	
					}
				}
			},
		});
		
		 
		var filter = new Ext.form.TextField({name: 'filterValue',
		style : {textTransform: "uppercase"},
		listeners: {
			
						specialkey: function(f,e){
								if(e.getKey() == e.ENTER){
									var filterVal = filter.getValue();
					
									if( filterVal.length > 0 ) 
									{  
										var o = {start: 0, limit: 500};
										Ext.namespace.storeUsuario.baseParams = Ext.namespace.storeUsuario.baseParams || {};
										Ext.namespace.storeUsuario.baseParams['buscar'] = filterVal;
										Ext.namespace.storeUsuario.reload({params:o});
									} 
									else {
									filterVal="*";
											var o = {start: 0, limit: 500};
										Ext.namespace.storeUsuario.baseParams = Ext.namespace.storeUsuario.baseParams || {};
										Ext.namespace.storeUsuario.baseParams['buscar'] = filterVal;
										Ext.namespace.storeUsuario.reload({params:o});
									}	
							}
						}
					}
		
		});

		var bfilter = new Ext.Toolbar.Button( 
		{
            text: 'Buscar',
            tooltip: "Utilizar '*' para busquedas ",            
            icon: '../img/view.png',
            handler: function(btn,e) 
			{
				var filterVal = filter.getValue();
				if( filterVal.length > 0 ) 
				{
					var o = {start: 0, limit: 500};
					Ext.namespace.storeUsuario.baseParams = Ext.namespace.storeUsuario.baseParams || {};
					Ext.namespace.storeUsuario.baseParams['buscar'] = filterVal;
					Ext.namespace.storeUsuario.reload({params:o});

				} else 
				{
					Ext.namespace.storeUsuario.clearFilter();
				}
            }
        });				
        var PAmenu = new Ext.Panel(
		{
			region: 'north',
			id: 'PAcabecera1',
			height: 29,     						
			tbar: [
					{
						//id: 'nuev',
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nuevo</a>',
						icon: '../img/Nuevo.png',									
						handler: function(t)
						{						  
							AltaUsuario();									
						
						}
					},
					{
						xtype: 'tbseparator'
					},
					{
						//id: 'modf',
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Modificar</a>',
						icon: '../img/Editar.png',
						handler: function(t)
						{													 
							ModificarUsuario(indice);
						}
					}, 
					{
						xtype: 'tbseparator'
					},
					{
						id: 'elim',
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Eliminar</a>',
						icon: '../img/Eliminar.png',
						handler: function(t)
						{								
							if(indice != 'e')
							{
							  Ext.MessageBox.show({							   
							   title:'Adbertencia',
							   msg: 'Esta seguro que desea eliminar el registro seleccionado..?',
							   buttons: Ext.MessageBox.YESNO,				           
							   icon: Ext.MessageBox.WARNING,
							   fn:function(btn) {
										if(btn == 'yes')
										{
										Ext.Ajax.request(
											{
												url : '../servicesAjax/DSBajaUsuarioAJAX.php' , 
												params : {codigo : Ext.namespace.storeUsuario.getAt(indice).get('codigo')},
												method: 'POST', 
												success: function ( result, request ) 
												{											
													Ext.namespace.storeUsuario.load({params:{start:0,limit:500}});
												},
												failure: function ( result, request) 
												{ 
													Ext.MessageBox.alert('ERROR', result.responseText); 
												} 
											});
										}
									}
							  });
							}else{alert('Seleccione un registro por favor.....!'+ indice);}	
						}
					}, 
					//
					// {
					// 	text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Revisor</a>',
					// 	icon: '../img/check.png',
					// 	handler: function(t)
					// 	{													 
					// 		revisor(Ext.namespace.storeUsuario.getAt(indice).get('codigo'),1)
					// 	}
					// }, 
					// {
					// 	text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Revisor</a>',
					// 	icon: '../img/delete.png',
					// 	handler: function(t)
					// 	{													 
					// 		revisor(Ext.namespace.storeUsuario.getAt(indice).get('codigo'),2)
					// 	}
					// },
					/* { // TODO: 2024-03-07
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Sincronizar EMD</a>',
						icon: '../img/Nuevo.png',
						handler: function(t)
						{													 
							sincronizar()
						}
					}, */
					// {
					// 	text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Sincronizar MadepApp</a>',
					// 	icon: '../img/Nuevo.png',
					// 	handler: function(t)
					// 	{													 
					// 		sincronizarReport()
					// 	}
					// },
					'->', filter, bfilter
				  ]
		});

			function revisor(indice,val)
			{
				cod = indice; 
				Ext.Ajax.request({  
				url: '../servicesAjax/DSRevisorUsuario.php',  
				method: 'POST',  
				params: {id:cod,val:val},  
				success: desactivo,  
				failure: no_desactivo  
				});  

				function desactivo(resp)  
				{  	
					Ext.MessageBox.alert('Mensaje', 'Cambios Guardados');  			
					Ext.namespace.storeUsuario.load();
				}  
		  
				function no_desactivo(resp)  
				{  			
					Ext.MessageBox.alert('Mensaje', resp.mensaje);  
				}  
			 }	
			 
			 
			var confP='';
			setTimeout(function(){                   
				confP = Ext.namespace.storeUsuario.getAt('0').get('configuracion');				
				configuracionRoles(confP);
			}, 1000);	
		 function configuracionRoles(conf)
		 {
			 if(conf.substring(0,1) == 0)
			   {	
					 var items = PAmenu.topToolbar.items;
					 items.get('nuev').disable();
			   }						  
			  if(conf.substring(1,2) == 0)
			   {	
					 var items = PAmenu.topToolbar.items;
					 items.get('elim').hide();
			   }						  
			   if(conf.substring(2,3) == 0)
			   {	
					 var items = PAmenu.topToolbar.items;
					 items.get('modf').disable();
			   }						  
		 }
		var viewport1 = new Ext.Viewport(
				{
					layout: 'border',
					items: [ PAmenu, UsuarioGrid]
				});    
	})	