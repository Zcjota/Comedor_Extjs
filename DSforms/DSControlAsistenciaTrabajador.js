/*!
 * DS- TPMV
 * Copyright(c) 2012
 */

	
  var winControlAsistenciaTrabajador;

	
	var rowIndex;
	var fecha;
	var fechaf;
	var ind;
	var ind1;
	var indicePer;
	var indHE;
	var next=0;
	var apuntador=0;
	var fm=Ext.form;
		var structure = {
        SISTEMA_CONTROL_ASISTENCIA: ['FECHA', 'HORARIO_ASIGNADO','MARCACION_REAL','VALIDACION'],
		},
		
		continentGroupRow = [],
		cityGroupRow = [];
		 var i=[4,4,4,15];
		var j=0;
		function generateConfig(){
       
			
        Ext.iterate(structure, function(continent, cities){
	
            continentGroupRow.push({
			
                header:  '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">'+continent+'</a>',
                align: 'center',
                colspan: cities.length 
				
            });
            Ext.each(cities, function(city){
				
                cityGroupRow.push({
                    header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">'+city+'</a>',
                    colspan: i[j],
                    align: 'center'
					 
                });
			j++;
                
            });
        })
    }
    
    // Run method to generate columns, fields, row grouping
    generateConfig();
	 var group = new Ext.ux.grid.ColumnHeaderGroup({
        rows: [continentGroupRow, cityGroupRow]
    });	
		
		var storePersona= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaPersonalInformeGRAJAX.php',   
			root: 'data',  
			totalProperty: 'total',		
			fields: ['codigo', 'nombre','nombreP','app','apm','codtrabajador','cargo','unidad','subcentro','centro','codcargo','codcentro'],
				
		});		
		

		var cboPer = new Ext.form.ComboBox(
		{   		
				
			width : 250,
			store: storePersona, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Personal...',   
			triggerAction: 'all',   		
			displayField:'nombre',   
			//typeAhead: true,
			valueField: 'codigo',
			hiddenName : 'cbpersonal',
			//selectOnFocus: true,
			forceSelection:true,
			listeners: {
						'select': function(cmb,record,index)
								{                    
									// 'codtrabajador','cargo','unidad','subcentro','centro'
									indicePer = index;	
									//txtNRO,txtCargo,txtUnidad,txtSubcentro,txtCentro
									txtNRO.setValue(storePersona.getAt(indicePer).get('codtrabajador'));
									txtCargo.setValue(storePersona.getAt(indicePer).get('cargo'));
									txtUnidad.setValue(storePersona.getAt(indicePer).get('unidad'));
									txtSubcentro.setValue(storePersona.getAt(indicePer).get('subcentro'));
									txtCentro.setValue(storePersona.getAt(indicePer).get('centro'));
								}
							    
			}		
		});	
			var storeAprobacionHE = new Ext.data.SimpleStore(
		{
			fields: ['codigoex', 'desex'],
			data : [					
									
						['1', 'APROBADO'],
						
							
				],   
			autoLoad: false 		
		});
		var storeHorario= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaHorarioCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeHorario.load();
		
		var cboHorario = new Ext.form.ComboBox(
		{   			
			width : 200,
			store: storeHorario, 
			mode: 'local',
			autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Horario...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbHorario',
			selectOnFocus: true,
			forceSelection:true,
			listeners: {
				'select': function(cmb,record,index){
						
							}		  
			}		
		});	
		var storeValidacionRetraso = new Ext.data.SimpleStore(
		{
			fields: ['codigoex', 'desex'],
			data : [					
						['1', 'SIN ACCION'],			
						['2', 'JUSTIFICADA'],
						['3', 'INJUSTIFICADA']
							
				],   
			autoLoad: false 		
		});
		var storeValidacionFaltas = new Ext.data.SimpleStore(
		{
			fields: ['codigoex', 'desex'],
			data : [					
						['1', 'SIN ACCION'],			
						['2', 'JUSTIFICADA'],
						['3', 'INJUSTIFICADA'],
						['4', 'LICENCIA']
							
				],   
			autoLoad: false 		
		});
			var storeAprobar = new Ext.data.SimpleStore(
		{
			fields: ['codigoex', 'desex'],
			data : [					
						['1', 'SI'],			
						['2', 'NO'],
						
							
				],   
			autoLoad: false 		
		});
		var cant;
		storeControlAsistenciaTrabajador = new Ext.data.JsonStore({   
			url: '../servicesAjax/DStraerControlAsistenciaPersonal.php',   
			root: 'data',   
			totalProperty: 'total',  		
			fields: ['editorRNM','colorr','codcolor','aprob','color','aprobador','editorRN','recargoNocturno','editorHE','nHE','HEN','HEF','HED','horasEfectivas','horasdehorario','validador','validacionFaltas','nvalidacionFaltas','nvalidacionRetraso','validacionRetraso','tick','Ndia','he','hs','he1','hs1','hiem','hism','hfem','hfsm','gestion','mes','dia','codigo','nombre','horarioOficial','nombreHorario','horario_oficial','IEH','IEM','IFH','IFM','horaEntradaR','minutoEntradaR','segundoEntradaR','marcacion','cod_cargo','nombrecargo','nombrecosto','nombresubcentro','nombreunidad','cod_centro','minuto','horasExtras','fechaMarcacion','fechaMarcacion1','minuto1','justificacion'],
			listeners: { 		       
					load: function(thisStore, record, ids) 
					{  					
						Ext.Msg.hide();											
					}
			}
			// listeners: { 		       
					// load: function(thisStore, record, ids) 
					// {  	
						// cant=this.getCount();
						// alert(cant);
					// }
			
			// }
			});  	
			 var sm = new Ext.grid.CheckboxSelectionModel(
			{
                singleSelect: false,
                listeners: 
				{
					rowselect: function(sm, row, rec) 
					{                        
						//indice = row;
						rowIndex = row;	
						//alert(indice);
                        						
                    }
                }
            });
			var Columnas1 = new Ext.ux.grid.LockingColumnModel( { 
			defaults: {
            sortable: true // columns are not sortable by default           
			},
			columns: [	
			{  
               header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;"></br></br></br></a>',  
                dataIndex: 'tick',                
				width:25,
                sortable: false,
				renderer: function(value, cell){  
					if(value==1)
					{
					str = "<img src='../images/rojo.png' WIDTH='15' HEIGHT='15'>";    
					return str; 
					
					}
					else
					{
						if(value==0)
						{
							str = "<img src='../images/verde.png' WIDTH='15' HEIGHT='15'>";    
							return str; 
						}
						else{
							if(value==3)
								{
									str = "<img src='../images/amarillo.png' WIDTH='15' HEIGHT='15'>";    
									return str; 
								}
								else
								{
									str = "<img src='../images/azul.jpg' WIDTH='15' HEIGHT='15'>";    
									return str; 
								}
						}
					
					}
				     
				},
				locked: true
            },{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: 'justificacion',
				width:25,				
				renderer: function(value, cell){  
					if(value==0)
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/pre1.png' WIDTH='13' HEIGHT='13'></div>";    
					else
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/pre2.png' WIDTH='13' HEIGHT='13'></div>";    
					return str; 
					
					
				     
				},
				locked: true
			},	
			{  
               header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">DIA</a>',  
                dataIndex: 'Ndia',   
				renderer: cantidadKit8,
				width:67,
                sortable: false,
				locked: true
            },	
			{  
               header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">FECHA</a>',  
                dataIndex: 'fechaMarcacion',                
				width:60,
				renderer: cantidadKit8,
                sortable: false,
				locked: true
            },
			{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO ASIGNADO</a>',  
				dataIndex: 'nombreHorario',    
                width: 150,
				renderer: cantidadKit7,
				editor: new Ext.form.ComboBox({
							width : 200,
						store: storeHorario, 
						mode: 'local',
						autocomplete : true,
						allowBlank: false,
						style : {textTransform: "uppercase"},
						emptyText:'Horario...',   
						triggerAction: 'all',   		
						displayField:'nombrep',   
						typeAhead: true,
						valueField: 'nombrep',
						hiddenName : 'cbHorario',
						selectOnFocus: true,
						forceSelection:true,
						cls :'name',
						listeners: {
							'select': function(cmb,record,index){
									if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('color')!='b' || storeControlAsistenciaTrabajador.getAt(rowIndex).get('aprob')==1)
									{
										ind=index;
										
										ActualizarHorario();
										// storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
										 
										// storeControlAsistenciaTrabajador.baseParams['fechaf'] = fechafin.getValue().format('Y-m-d');
										 // Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 // window.setTimeout(function()
										 // {
										   // Ext.Msg.hide();							  
													   // /*********************/
												
													// // storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
												// storeControlAsistenciaTrabajador.load();
			   
													   // /********************/
										 // },3500);	
										
									}
									else
									{
										alert("No Se Puede Cambiar Datos");
									}
										//alert(storeHorario.getAt(ind).get('codigop'));
									//storeUnidad.load({params:{cbCentro: cboCentro.getValue()}});	
								
								}
									  
						}		
                   
                })
              
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO </BR>INICIO</a>',  
                dataIndex: 'he', 
				renderer: cantidadKit8,				
                width: 40,
                sortable: false,
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO </BR> SALIDA</a>',  
                dataIndex: 'hs',  
				renderer: cantidadKit8,
                width: 40,
                 sortable: false,
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO </BR> INICIO</a>',  
                dataIndex: 'he1', 
				renderer: cantidadKit8,				
                width: 40,
                 sortable: false,
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO</BR>SALIDA</a>',  
                dataIndex: 'hs1', 
				renderer: cantidadKit8,
                width: 40,
                 sortable: false,
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">INICIO</a>',  
                dataIndex: 'hiem',
				renderer: cantidadKit8,
                width: 40,
                sortable: false,
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">SALIDA</a>',  
                dataIndex: 'hism',  
				renderer: cantidadKit8,
                width: 40,
                sortable: false,
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">INICIO</a>',  
                dataIndex: 'hfem', 
				renderer: cantidadKit8,				
                width: 40,
                 sortable: false,
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">SALIDA</a>',  
                dataIndex: 'hfsm',  
				renderer: cantidadKit8,
                width: 40,
                sortable: false,
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">ATRASO </BR> (MIN)</a>',  
                dataIndex: 'minuto', 
				renderer: cantidadKit8,				
                width: 45,
                 sortable: false,
				 hidden:true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">ATRASO </BR> (MIN)</a>',  
                dataIndex: 'minuto1', 
				renderer: cantidadKit8,				
                width: 45,
                 sortable: false,
				hidden:true
			}
			,{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">RETRASO</a>',  
				dataIndex: 'nvalidacionRetraso', 
				
                width: 70,
				renderer: cantidadKit7,
				hidden:true,
				editor: new Ext.form.ComboBox({
							width : 150,
						store: storeValidacionRetraso, 
						mode: 'local',
						autocomplete : true,
						allowBlank: false,
						style : {textTransform: "uppercase"},  
						triggerAction: 'all',   		
						displayField:'desex',   
						typeAhead: true,
						valueField: 'desex',
						hiddenName : 'cbValida',
						selectOnFocus: true,
						forceSelection:true,
						cls :'name',
						listeners: {
							'select': function(cmb,record,index){
								if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('color')!='b' || storeControlAsistenciaTrabajador.getAt(rowIndex).get('aprob')==1)
									{
										if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('minuto')!='F' && storeControlAsistenciaTrabajador.getAt(rowIndex).get('minuto')!='SM' && storeControlAsistenciaTrabajador.getAt(rowIndex).get('hfsm')!='' && storeControlAsistenciaTrabajador.getAt(rowIndex).get('hiem')!='' )
										{
											ind1=index;
											if(index==1)
											{
												MotivoAprobacion(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'),0,0,0,storeControlAsistenciaTrabajador.getAt(rowIndex).get('minuto'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('minuto1'));
											}
											else
											{
												ActualizarJustificacionRetraso();
												// storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
												// Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
												// window.setTimeout(function()
												// {
													// Ext.Msg.hide();							  
														   // /*********************/
													
														// // storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
													 // storeControlAsistenciaTrabajador.load();
				   
														   // /********************/
												// },3500);	
											}
										}
										else
										{
											alert("POR FAVOR VALIDE EN LA COLUMNA FALTAS");
											Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 
												 // window.setTimeout(function()
												 // {
												   // Ext.Msg.hide();							  
															   /*********************/
														 storeControlAsistenciaTrabajador.load();
															// storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
														
					   
															   /********************/
											//	 },4000);
										
										}
									}
								else
									{
									 alert("No Se Puede Cambiar Datos");
									  Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 
												 // window.setTimeout(function()
												 // {
												   // Ext.Msg.hide();							  
															   /*********************/
														 storeControlAsistencia.load();
															// storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
														
					   
															   /********************/
												// },4000);
									}		
								}
									  
						}		
                   
                })
              
			},{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">FALTAS</a>',  
				dataIndex: 'nvalidacionFaltas',    
                width: 70,
				renderer: cantidadKit7,
				hidden:true,
				editor: new Ext.form.ComboBox({
							width : 150,
						store: storeValidacionFaltas, 
						mode: 'local',
						autocomplete : true,
						allowBlank: false,
						style : {textTransform: "uppercase"},  
						triggerAction: 'all',   		
						displayField:'desex',   
						typeAhead: true,
						valueField: 'desex',
						hiddenName : 'cbValida1',
						selectOnFocus: true,
						forceSelection:true,
						cls :'name',
						listeners: {
							'select': function(cmb,record,index){
								if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('color')!='b'|| storeControlAsistenciaTrabajador.getAt(rowIndex).get('aprob')==1)
									{
										if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('minuto')=='F' || storeControlAsistenciaTrabajador.getAt(rowIndex).get('minuto')=='SM' || storeControlAsistenciaTrabajador.getAt(rowIndex).get('hfsm')=='' || storeControlAsistenciaTrabajador.getAt(rowIndex).get('hiem')=='')
										{
											ind2=index;
											if(index==1)
											{
												apuntador=1;
												MotivoAprobacion(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'),0,0,0);
											}
											else
											{
												if(index==3)
												{
													MotivoAprobacionL(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'));
													
												}
												else
												{
													ActualizarJustificacionFalta();
													
												}
											}
										}
											else
										{
											alert("POR FAVOR VALIDE EN LA COLUMNA RETRASO");
											Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 
												 // window.setTimeout(function()
												 // {
												   // Ext.Msg.hide();							  
															   /*********************/
														 storeControlAsistenciaTrabajador.load();
															// storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
														
					   
															   /********************/
												 //},4000);
										}
									}
									else
									{
									 alert("No Se Puede Cambiar Datos");
									  Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 
												 // window.setTimeout(function()
												 // {
												   // Ext.Msg.hide();							  
															   /*********************/
														 storeControlAsistenciaTrabajador.load();
															// storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
														
					   
															   /********************/
												 //},4000);
									}		
								}
									  
						}		
                   
                })
              
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">VALIDADO POR</a>',  
                dataIndex: 'validador', 
				renderer: cantidadKit8,
                width:150,
                 sortable: false,
				 hidden:true
			}
			
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </BR> EXTRAS</a>',  
                dataIndex: 'horasExtras',
				renderer: cantidadKit8,
                width: 45,
                 sortable: false,
				 hidden:true
			},
			{                  
				header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </br> EXTRAS </br> NORMAL</a>',  
				dataIndex: 'HEN',
				width: 45,
				renderer: cantidadKit6,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false}),
				hidden:true
				
			},
			{                  
				header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </BR> EXTRAS </BR> FERIADO</a>',  
				dataIndex: 'HEF',
				width: 45,
				renderer: cantidadKit6,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false}),
				hidden:true
				
			},
			{                  
				header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </BR> EXTRAS </BR> DOMINGO</a>',  
				dataIndex: 'HED',
				width: 45,
				renderer: cantidadKit6,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false}),
				hidden:true
				
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">RECARGO </BR> NOCTURNO</a>',  
                dataIndex: 'editorRNM', 
				renderer: cantidadKit8,
                width:58,
                 sortable: false,
				 hidden:true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">RECARGO </BR> NOCTURNO </BR> APROB.</a>',  
                dataIndex: 'editorRN',  
                width:60,
                 sortable: false,
				renderer: cantidadKit6,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false}),
				hidden:true
			},
			{    header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">GUARDAR </BR> EDICION</a>',
				dataIndex: 'codigo',
				
				width: 70,
				//renderer: renderBtn,
				 sortable: false,
				hidden:true
			},{  
                //header: '<a style ="color:#15428B; font: bold 10px tahoma,arial,verdana,sans-serif;">HORAS EXTRAS Y RECARGO </BR> NOCTURNO REVISADO POR</a>',  
				header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">EDITOR DE HORAS EXTRAS </BR> Y RECARGO NOCTURNO</a>', 
                dataIndex: 'editorHE',  
				renderer: cantidadKit8,
                width:200,
                sortable: false,
				hidden:true
			},{    header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">APROBAR</a>',
				dataIndex: 'color',
					width: 70,
				renderer: cantidadKit7,
				hidden:true
				// editor: new Ext.form.ComboBox({
							// width : 150,
						// store: storeAprobar, 
						// mode: 'local',
						// autocomplete : true,
						// allowBlank: false,
						// style : {textTransform: "uppercase"},  
						// triggerAction: 'all',   		
						// displayField:'desex',   
						// typeAhead: true,
						// valueField: 'desex',
						// hiddenName : 'cbaprobar',
						// selectOnFocus: true,
						// forceSelection:true,
						// cls :'name',
						// listeners: {
							// 'select': function(cmb,record,index){
								// }
						// }})
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">APROBADOR</a>',  
                dataIndex: 'aprobador',  
				renderer: cantidadKit8,
                width:200,
                sortable: false,
				hidden:true
			},{  
               header: '<a style =color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;></a>',  
                dataIndex: 'tick',                
				width:0,
                sortable: false,
				renderer: function(value, cell){  
					//alert(value);
					if(value==1)
					{
					str = "<img src='../images/vacio.jpg' WIDTH='20' HEIGHT='15'>";    
					return str; 
					
					}
					else
					{
						if(value==0)
						{
							str = "<img src='../images/vacio.jpg' WIDTH='20' HEIGHT='15'>";    
							return str; 
						}
						else{
							if(value==3)
								{
									str = "<img src='../images/vacio.jpg' WIDTH='20' HEIGHT='15'>";    
									return str; 
								}
								else
								{
									str = "<img src='../images/vacio.jpg' WIDTH='20' HEIGHT='15'>";    
									return str; 
								}
						}
					
					}
				     
				},
				
            },
			]  
			});
			function cantidadKit8(value, metadata, record, rowIndex, colIndex, store) {  
			// metadata.attr = 'style="font-size:8px;"';    
			 // return value; 
			 if (record.data['colorr'] == 'APROBADO'){
			metadata.attr = 'style="font-size:8px;background-color: #81BEF7"';    
			 return value; 
			 }
			 else
			 {
				metadata.attr = 'style="font-size:8px"';    
			 return value; 
			 }
		}
				function cantidadKit7(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="background-color:#CAFF70;font-size:8px;"';    
			 return value; 
		}
			function cantidadKit6(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="background-color:#CAFF70;text-align:center;font-size:8px;"';    
			 return value; 
		}
		 function renderBtn1(val, p, record) {  
			var contentId = Ext.id();
			createGridButton1.defer(1, this, [val, contentId, record]);
			return('<div id="' + contentId + '"></div>');
		}
		function GuardarAprobador(value1,fecha1)
		{
			Ext.Ajax.request({
				url:'../servicesAjax/DSValidarAprobador.php',
				method:'POST',
				params:{codigo:value1,fecha:fecha1},
				sucess:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					// Ext.dsdata.storeCliente.load({params:{start:0,limit:25	}});	

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
		}
				function createGridButton1(value, contentid, record) {
			new Ext.Button({text: 'APROBAR', handler : function(btn, e) {
			// alert(value);
			// alert(contentid);
			// alert(record);
			if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('tick')!=1)
			{
			
				if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('color')!='b')
				{
				MotivoAprobacion(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'),0,2,value);
				}
				else
				{
					 alert("No Se Puede Cambiar Datos");
				}
			}
			else{
			alert("El Semaforo Esta Rojo");
			}
		
	
		}}).render(document.body, contentid);
	}
		 function renderBtn(val, p, record) {  
			var contentId = Ext.id();
			createGridButton.defer(1, this, [val, contentId, record]);
			return('<div id="' + contentId + '"></div>');
		}
				 function createGridButton(value, contentid, record) {
			   new Ext.Button({text: 'GUARDAR', handler : function(btn, e) {
			   if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('color')!='b' || storeControlAsistenciaTrabajador.getAt(rowIndex).get('aprob')==1)
			{
				if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('horasExtras')!='F')
				{
					MotivoAprobacion(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'),0,1,value);
				}
				else
				{
					alert("No Se Puede Guardar Datos Cuando es Falta");
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					 window.setTimeout(function()
					 {
						 Ext.Msg.hide();							  
																	   /*********************/
						 storeControlAsistenciaTrabajador.load();
							   
																	   /********************/
					},3000);
				}
				
			}
			else
			{
				 alert("No Se Puede Cambiar Datos");
				  Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					 window.setTimeout(function()
					 {
						 Ext.Msg.hide();							  
																	   /*********************/
						 storeControlAsistenciaTrabajador.load();
							   
																	   /********************/
					},3000);
			}
			
			   }}).render(document.body, contentid);
		   
		  }
		  function reload()
		  {
			ActualizarJustificacionFalta();
												
		  }
		function ActualizarJustificacionFalta()
			{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSValidarFalta.php',
				method:'POST',
				params:{validarFalta:storeValidacionFaltas.getAt(ind2).get('codigoex'),codigo:storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),fecha:storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1')},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
													Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
											 						  
															   /*********************/
														 storeControlAsistenciaTrabajador.load();
															
															   /********************/
													

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
			}
		function ActualizarJustificacionRetraso()
			{
			//alert(storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'));
				Ext.Ajax.request({
				url:'../servicesAjax/DSValidarRetraso.php',
				method:'POST',
				params:{validarRetraso:storeValidacionRetraso.getAt(ind1).get('codigoex'),codigo:storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),fecha:storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1')},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
												Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
												// window.setTimeout(function()
												// {
													// Ext.Msg.hide();							  
														   /*********************/
													
														// storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
													 storeControlAsistenciaTrabajador.load();
				   
														   /********************/
												//},3500);		

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
			}
    
	var GridControlAsistencia = new Ext.grid.EditorGridPanel({  
			id: 'gridAsistencia1',
			region:'center',
	
			//width :1090,	
			height : 500,
			 //autoExpandColumn: 'codigo',
			store: storeControlAsistenciaTrabajador,
							
			cm: Columnas1,
			
			single: true,
			sm: sm,
			listeners:
			{
					
				'cellclick' : function(grid, rowIndex, cellIndex, e){
						var store = grid.getStore().getAt(rowIndex);
						var columnName = grid.getColumnModel().getDataIndex(cellIndex);
						var cellValue = store.get(columnName);
						if(cellIndex==1)
						{
							//alert("hola");
							   var auxi=0;
								MotivoAprobacion(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'),auxi,0,0);//ExportaraExcel(); 
							// MotivoAprobacion(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha,auxi,0,0);//ExportaraExcel(); 
						}
				

				}
			},
			border: true,   
			enableColLock:false,
			stripeRows: false,
			view: new Ext.ux.grid.LockingGridView(),
			viewConfig:{
				getRowClass : function (row, index) {
					var cls = '';	
					//alert(row.get('color'));
					//alert();
					if(row.get('color') == 'y' ){
						cls = 'ColorAmarilo';
					}
					if(row.get('colorr') == 'SI' ){
						cls = 'ColorAzul';
					}
					if(row.get('color') == 'r' ){
						cls = 'ColorRojo';
					}
					
					return cls; 
				 }	
			},
		//	plugins: group
			 
		});			
	
		var btnLimpiar = new Ext.Button({
		    id: 'btnLimpiar',
			x: 260,
			y: 430,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmControlAsistencia.getForm().reset;					
				winControlAsistenciaTrabajador.hide();
			} 
		});	
		
		function Resetear()
		{ 
		
			GridControlAsistencia.removeAll();
			registrosGrid1=0;
		}	
		
		function GuardarArray1(value) { 
			var store = Ext.getCmp("gridAsistencia1").getStore();
		
			var datosGrid1 = []; 
				var i=0;			
			store.each(function(rec){                                                       
				datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
						i++;
   			});    	
			
			registrosGrid2 = Ext.encode(datosGrid1);
			ActualizarHE(registrosGrid2,value);
			//alert(registrosGrid2);
			
		}; 	
		function ActualizarHE(registros,value)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarHE.php',
				method:'POST',
				params:{registros:registros,codigo:value,fecha:storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1')},
				sucess:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					// Ext.dsdata.storeCliente.load({params:{start:0,limit:25	}});	

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
		}
		var fechaini = new Ext.form.DateField({
		name: 'fecha1',
		hideLabel: true, 
		maxLength : 10,
		width: 91,
			
		format : 'd/m/Y',
		//allowBlank: true,		
		enableKeyEvents: true,
		selectOnFocus: true,
		
		});		
		var fechafin = new Ext.form.DateField({
		name: 'fecha2',
		hideLabel: true, 
		maxLength : 10,
		width: 91,
			
		format : 'd/m/Y',
		//allowBlank: true,		
		enableKeyEvents: true,
		selectOnFocus: true,
		
		});
		
		
			
		var bfilter = new Ext.Toolbar.Button(
		{
			text: 'Buscar',
			tooltip: "Utilizar '*' para busquedas ",       		
			icon: '../img/view.png',
			handler: function(btn,e) {
				
				var fechiniv;
				if (fechaini.getValue() > 0)
					{fechiniv = fechaini.getValue().format('Y-m-d');}
				else
					{fechiniv = '';}
					
				var fechfinv;
				if (fechaini.getValue() > 0)
					{fechfinv = fechafin.getValue().format('Y-m-d');}
				else
					{fechfinv = '';}	
				
				if( fechiniv.length > 0 )
				{  
					var o = {start : 0, limit:100};					
				
					storeControlAsistenciaTrabajador.baseParams['fechai'] = fechiniv;
					storeControlAsistenciaTrabajador.baseParams['fechaf'] = fechfinv;
					storeControlAsistenciaTrabajador.baseParams['codigoT'] = storePersona.getAt(indicePer).get('codtrabajador');
					storeControlAsistenciaTrabajador.baseParams['codigo'] = storePersona.getAt(indicePer).get('codigo');
					storeControlAsistenciaTrabajador.baseParams['codcargo'] = storePersona.getAt(indicePer).get('codcargo');
					storeControlAsistenciaTrabajador.baseParams['codcentro'] = storePersona.getAt(indicePer).get('codcentro');
				
					//frmControlAsistencia.guardarDatos();
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 // window.setTimeout(function()
										 // {
										   // Ext.Msg.hide();							  
													   // /*********************/
												
													// // storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
			
			   
													   // /********************/
										 // },2000);	
					
					storeControlAsistenciaTrabajador.load();
					
		
				} else {
					storeControlAsistenciaTrabajador.clearFilter();
				}	
				fecha=fechaini.getValue().format('Y-m-d');
				fechaf=fechafin.getValue().format('Y-m-d');
				
			}
		});	
				
		var frmControlAsistencia = new Ext.FormPanel({ 
			// frame:true, 
			// selectOnFocus: true,
			// layout: 'absolute',
			// width: 1120,
			// height: 500,
			items:[ GridControlAsistencia],
			guardarDatos: function(){
				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DStraerControlAsistencia.php',
						params :{fechai:fecha},  
						method: 'POST',
							waitTitle: 'Conectando',
						waitMsg: 'Enviando Datos...',
						success: function(form, action)
						{		
							storeControlAsistenciaTrabajador.reload();
							//Ext.MessageBox.alert('MSG', 'CAMBIOS GUARDADOS'); 
							//storeControlAsistenciaTrabajador.load({params:{idcliente:codcliente1,idproyecto:codproyecto1,idmes:codmes1,idgestion:codgestion1}});
						},					
						failure: function(form, action)
						{
							if (action.failureType == 'server') 
							{
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function()
								{
								
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
	
		var GuardarMarcacion = new Ext.Action({
       text: 'GUARDAR',
						icon: '../img/save.png',
						handler: function()
						{
						
							GuardarArray1();
							frmControlAsistencia.guardarDatos();
						}
		});
		var registrosGridexcel;
		function Registro() { 
			var store = Ext.getCmp("gridAsistencia1").getStore();
		
			var datosGrid1 = []; 
				var i=0;			
			store.each(function(rec){                                                       
				datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
						i++;
   			});    	
			
			registrosGridexcel = Ext.encode(datosGrid1);
			//alert(registrosGridexcel);
		}
		function ExportaraExcel()
		{
					Ext.Ajax.request({
					url:'../servicesAjax/DSpasarExcelreloj.php',
					method:'POST',
					params:{reg:registrosGridexcel},
					success:desactivo,
					failures:no_desactivo
					});
				
					function desactivo(resp)
					{
						
						location = "../servicesAjax/DSExcelControlAsistenciaPersonal.php?fecha="+fecha+'&fechaf='+fechaf+'&codPersona='+storePersona.getAt(indicePer).get('codtrabajador');  

					}
					function no_desactivo(resp)
					{
						
					}

		}
		// function ExportaraExcel()
		// {
			
			// location = "../servicesAjax/DSExcelControlAsistenciaPersonal.php?fecha="+fecha+'&fechaf='+fechaf+'&codPersona='+storePersona.getAt(indicePer).get('codtrabajador');  

		// }
		var lblTrabajador	= new Ext.form.Label({
			text: 'Trabajador  :',
			height: 20,
			cls: 'x-label'
		});
		
		var lblNroTrabajador	= new Ext.form.Label({
			text: 'Codigo  : ',
			height: 20,
			cls: 'x-label'
		});
		var lblCargo	= new Ext.form.Label({
			text: 'Cargo  : ',
			height: 20,
			cls: 'x-label'
		});
		var txtNRO = new Ext.form.TextField({
				name: 'nro',
				//hideLabel: true,	
				maxLength : 150,
				width: 80,
				readOnly:true,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					
				}
		});	
		var txtCargo = new Ext.form.TextField({
				name: 'Cargo',
				//hideLabel: true,	
				maxLength : 150,
				width: 250,
				readOnly:true,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					
				}
		});	
		var lblUnidad	= new Ext.form.Label({
			text: 'Unidad  : ',
			height: 20,
			cls: 'x-label'
		});
		var txtUnidad = new Ext.form.TextField({
				name: 'Unidad',
				//hideLabel: true,	
				maxLength : 180,
				width: 130,
				readOnly:true,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					
				}
		});	
		var lblSubcentro	= new Ext.form.Label({
			text: 'Subcentro  : ',
			height: 20,
			cls: 'x-label'
		});
		var txtSubcentro = new Ext.form.TextField({
				name: 'Subc',
				//hideLabel: true,	
				maxLength : 150,
				width: 100,
				readOnly:true,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					
				}
		});	
		var lblcentro	= new Ext.form.Label({
			text: 'Centro  : ',
			height: 20,
			cls: 'x-label'
		});
		var txtCentro = new Ext.form.TextField({
				name: 'Cent',
				//hideLabel: true,	
				maxLength : 150,
				width: 250,
				readOnly:true,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					
				}
		});
		var lblFechaIni	= new Ext.form.Label({
			text: 'De  : ',
			height: 20,
			cls: 'x-label'
		});		
		var lblFechaFin	= new Ext.form.Label({
			text: 'Hasta  : ',
			height: 20,
			cls: 'x-label'
		});	
		LlenarMotivoAprobacion = function(fechaap, motivoap,motivog2,motivog3,ban,valor,fechaAprobar,minutosj){
		
			//alert(motivoap);
			//alert(fecha);
			if(ban==0){
			Aprobar(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'), fechaap, motivoap,motivog2,motivog3,minutosj);}
			if(ban==1){
			Aprobar(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'), fechaap, motivoap,motivog2,motivog3);
			horasextras(valor);}
			if(ban==2){
			Aprobar(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'), fechaap, motivoap,motivog2,motivog3);
			aprobada(valor,fechaAprobar);}
		}
			function aprobada(valor,fecha)
		{
					GuardarAprobador(valor,fecha);
					//storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					 window.setTimeout(function()
					 {
						 Ext.Msg.hide();							  
																	   /*********************/
						 storeControlAsistenciaTrabajador.load();
						   
																   /********************/
					},3000);
		}
			function horasextras(valor)
			{
				if(storeControlAsistenciaTrabajador.getAt(rowIndex).get('horasExtras')!="F")
						{
							GuardarArray1(valor);
						}
											
					 storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					 window.setTimeout(function()
					 {
						 Ext.Msg.hide();							  
																	   /*********************/
						 storeControlAsistenciaTrabajador.load();
							   
																	   /********************/
					},3000);
			}
		// LlenarMotivoAprobacion = function(fechaap, motivoap){
			// //alert(motivoap);
			// //alert(fecha);
			// Aprobar(storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1'), fechaap, motivoap);
		// }
		 
		function Aprobar(idSel,fechaj, fechaap, motivoap,motivog2,motivog3,minutosj){

			Ext.Ajax.request({  
            url: '../servicesAjax/DSAprobarJustificacionAJAX.php',  
            method: 'POST',  
            params: {codigo:idSel,fecha:fechaj,fecha1:fechaap,motivo1:motivoap,motivog2:motivog2,motivog3:motivog3,minutosj:minutosj},  
            success: desactivo,  
            failure: no_desactivo  
			});  
  
			function desactivo(resp)  
			{ 				
				var data = Ext.util.JSON.decode(resp.responseText);
				var coddoc = data.message.reason;
				next=coddoc;
					if(next!=0)
								{
									next=0;
									if(apuntador==1)
									{
									ActualizarJustificacionFalta();
									apuntador=0;
									}
									else{
									 ActualizarJustificacionRetraso();}
							
										
										 // storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
									 // Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 // window.setTimeout(function()
										 // {
										   // Ext.Msg.hide();							  
													   // /*********************/
												
													// // storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
												 // storeControlAsistenciaTrabajador.load();
			   
													   // /********************/
										 // },3000);	
										 
										 
										//storeControlAsistencia.baseParams['fechaf'] = fechafin.getValue().format('Y-m-d');
									
										//alert(storeHorario.getAt(ind).get('codigop'));
									//storeUnidad.load({params:{cbCentro: cboCentro.getValue()}});	
								}
						else{alert("NO TIENE GLOZA");}
			}  
      
			function no_desactivo(resp)  
			{  			
				Ext.MessageBox.alert('Mensaje', resp.mensaje);  
			}  
        }
		LlenarMotivoAprobacione = function(fechaap, motivo,tip){
		//alert(motivo);
			if(tip==1){
				GuardarArrayVarios(motivo,fechaap);}
			if(tip==2){
			GuardarArrayVariosAprobar(motivo,fechaap);
				}
		
		}	
		function GuardarArrayVariosAprobar(motivo1,fechaap) { 
			
				var datosGrid = [];  
						sm.each(function(rec){         
							
							datosGrid.push(Ext.apply({id:rec.id},rec.data));            
						});    
						registrosGrid = Ext.encode(datosGrid);
					
			ActualizarHETodas1(registrosGrid,motivo1,fechaap);
			
		};
		function ActualizarHETodas1(registros,motivo,fechaap)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarAprobadorVarios.php',
				method:'POST',
				params:{registros:registros,fecha:fecha,motivo:motivo,fechaap:fechaap},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue();
					storeControlAsistenciaTrabajador.baseParams['fechaf'] = fechafin.getValue();
					storeControlAsistenciaTrabajador.baseParams['codigoT'] = storePersona.getAt(indicePer).get('codtrabajador');
					storeControlAsistenciaTrabajador.baseParams['codigo'] = storePersona.getAt(indicePer).get('codigo');
					
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 // window.setTimeout(function()
										 // {
										   // Ext.Msg.hide();							  
													   // /*********************/
												
													// // storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
												
			   
													   // /********************/
										 // },6000);	
					storeControlAsistenciaTrabajador.load();
					
					// Ext.dsdata.storeCliente.load({params:{start:0,limit:25	}});	

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
		}
		function GuardarArrayVarios(motivo1,fechaap) { 
			var store = Ext.getCmp("gridAsistencia1").getStore();
		
			var datosGrid1 = []; 
				var i=0;			
			store.each(function(rec){                                                       
				datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
						i++;
   			});    	
			
			registrosGrid2 = Ext.encode(datosGrid1);
			//alert(registrosGrid2);
			ActualizarHETodas(registrosGrid2,motivo1,fechaap);
			
		}; 	
		function ActualizarHETodas(registros,motivo,fechaap)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarHEVarios.php',
				method:'POST',
				params:{registros:registros,fecha:fecha,motivo:motivo,fechaap:fechaap},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue();
					storeControlAsistenciaTrabajador.baseParams['fechaf'] = fechafin.getValue();
					storeControlAsistenciaTrabajador.baseParams['codigoT'] = storePersona.getAt(indicePer).get('codtrabajador');
					storeControlAsistenciaTrabajador.baseParams['codigo'] = storePersona.getAt(indicePer).get('codigo');
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					storeControlAsistenciaTrabajador.load();
					
				}
				function no_desactivo(resp)
				{
				}
		}
	var PAmenu = new Ext.Panel({
		region: 'north',
		id: 'PAmenuPr',
		height: 29,   
		tbar: [{
				xtype: 'buttongroup',
				 columns: 2,
                 defaults: { scale: 'small'},
				items: [lblTrabajador,cboPer,lblNroTrabajador,txtNRO,lblCargo,txtCargo
						
						]
			},
			{
				xtype: 'buttongroup',
				columns: 2,
				 defaults: { scale: 'small'},
				items: [
				        lblUnidad,txtUnidad,
						lblSubcentro,txtSubcentro,lblcentro,txtCentro
						]
			},
			{
				xtype: 'buttongroup',
				columns: 2,
				 defaults: { scale: 'small'},
				items: [
						lblFechaIni,fechaini,
						lblFechaFin,fechafin
						]
			},
			{
				xtype: 'buttongroup',
				columns: 1,
				 defaults: { scale: 'small'},
				items: [
						 bfilter,	
							{
								text: 'XLS',
								icon: '../img/excel.png',
								handler: function confirm() 
								{	
									Registro();
									ExportaraExcel(); 
								}
							}
							
						]
			},
			
			{
				xtype: 'buttongroup',
				columns: 1,
				 defaults: { scale: 'small'},
				items: [
						{
								text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Guardar Edicion</a>',
								icon: '../img/save.png',
								handler: function confirm() 
								{	
									MotivoApro(1);
									
								}
							},{
								text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Aprobar Masivo</a>',
								icon: '../img/check.png',
								handler: function confirm() 
								{	
									MotivoApro(2);
									
								}
							}
						]
			}
											
			]
	});		
		
			function ActualizarHorario()
			{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSValidarControlAsistencia.php',
				method:'POST',
				params:{horario:storeHorario.getAt(ind).get('codigop'),codigo:storeControlAsistenciaTrabajador.getAt(rowIndex).get('codigo'),fecha:storeControlAsistenciaTrabajador.getAt(rowIndex).get('fechaMarcacion1')},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
									storeControlAsistenciaTrabajador.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
										 
										storeControlAsistenciaTrabajador.baseParams['fechaf'] = fechafin.getValue().format('Y-m-d');
										 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 // window.setTimeout(function()
										 // {
										   // Ext.Msg.hide();							  
													   /*********************/
												
													// storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
												storeControlAsistenciaTrabajador.load();
			   
													   /********************/
										// },3500);	

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
			}
	//alert("hhhh");
		function IngresarControlAsistencia()
		{	
			//validar();
			//alert("hdddhhh");
			var viewport1 = new Ext.Viewport(
			{
				 layout: 'border',
							
				items: [PAmenu,GridControlAsistencia]
			}); 
		
			storePersona.load();
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
				//mes=String.concat("0",mes);
			}
			
			fechai="01/"+mes+"/"+year;
			
			fechaini.setValue(fechai);
			
			fecha=year+"-"+mes+"-01";
	
			fechafin.setValue(fechaActual);
			fechaf=fechaActual.format('Y-m-d');
		
			
			//winControlAsistenciaTrabajador.show();				
		}
	
	
		

       
		