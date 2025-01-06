/*!
 * DS- TPMV
 * Copyright(c) 2012
 */
  var winControlAsistencia;

	var codProyecto ;
	var codm;
	var codges;
	var rowIndex=-1;
	var fecha;
	var ind;
	var ind1;
	var ind2;
	var indHE;
	var next=0;
	var apuntador=0;
	var filtro="NN";
	var fm=Ext.form;
		var structure = {
        SISTEMA_CONTROL_ASISTENCIA: ['DATOS_GENERALES', 'HORARIO_ASIGNADO','MARCACION_REAL','VALIDACIONES'],
		},
		products = ['ProductX', 'ProductY'],
		continentGroupRow = [],
		cityGroupRow = [];
		 var i=[9,4,4,15];
		var j=0;
		function generateConfig(){
        var arr,
           numProducts = products.length;
        Ext.iterate(structure, function(continent, cities){
            continentGroupRow.push({
			
                header:  '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">'+continent+'</a>',
                align: 'center',
				renderer: cantidadKit8,	
                colspan: cities.length 
				
            });
            Ext.each(cities, function(city){
				
                cityGroupRow.push({
                    header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">'+city+'</a>',
					renderer: cantidadKit8,	
                    colspan: i[j],
                    align: 'center'
					
                });
			j++;
               
            });
        })
    }
	var rdirecto=1;
	var rextendido=0;
    var chkdirectos = [
		  {
			xtype  : 'checkbox',
		
			name: 'directos',
			id: 'directo',
			boxLabel: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Reportes Directos</a>',
			//   : 'Reportes Directos',
			inputValue : '1',
			checked: true,
			handler: function() { 				
				if (this.getValue() == true)
				{
					rdirecto=1;
					storeControlAsistencia.baseParams['filtro'] = filtro;
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			
					storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
					storeControlAsistencia.baseParams['rdirecto'] = rdirecto;
					storeControlAsistencia.baseParams['rextendido'] =rextendido;
					storeControlAsistencia.load();		
				}
				else
				{
					rdirecto=0;
					storeControlAsistencia.baseParams['filtro'] = filtro;
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			
					storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
					storeControlAsistencia.baseParams['rdirecto'] = rdirecto;
					storeControlAsistencia.baseParams['rextendido'] =rextendido;
					storeControlAsistencia.load();
				} 
			} 		  
		  }
	    ]
		 var chkextendido = [
		  {
			xtype  : 'checkbox',
		
			name: 'extendido',
			id: 'extendido',
			boxLabel: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Reportes Extendido</a>',
		//	boxLabel   : 'Reportes Extendido',
			inputValue : '0',
			handler: function() { 				
				if (this.getValue() == true)
				{
					rextendido=1;
					storeControlAsistencia.baseParams['filtro'] = filtro;
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			
					storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
					storeControlAsistencia.baseParams['rdirecto'] = rdirecto;
					storeControlAsistencia.baseParams['rextendido'] =rextendido;
					storeControlAsistencia.load();
				}
				else
				{
					rextendido=0;
					storeControlAsistencia.baseParams['filtro'] = filtro;
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			
					storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
					storeControlAsistencia.baseParams['rdirecto'] = rdirecto;
					storeControlAsistencia.baseParams['rextendido'] =rextendido;
					storeControlAsistencia.load();
				} 
			} 		  
		  }
	    ]
    // Run method to generate columns, fields, row grouping
    generateConfig();
	 var group = new Ext.ux.grid.ColumnHeaderGroup({
        rows: [continentGroupRow, cityGroupRow]
    });	

		var storeHorario= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaHorarioCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeHorario.load();
	var storeValidacionRetraso = new Ext.data.SimpleStore(
		{
			fields: ['codigoex', 'desex'],
			data : [					
						['1', 'SIN ACCION'],			
						['2', 'JUSTIFICADA'],
						['3', 'INJUSTIFICADA'],
						
							
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
	var timeField =  new Ext.form.TimeField({
				fieldLabel: 'Time Field',
			   //minValue: '4:00',
			  // maxValue: '23:59',
			   increment: 15,
			   format:'H:i',
			   name:'cb-time',
				cls :'name',			   
		});
	var storeValidacionFaltas = new Ext.data.SimpleStore(
	{
		fields: ['codigoex', 'desex'],
		data : [					
					['1', 'SIN ACCION'],			
					['2', 'JUSTIFICADA'],
					['3', 'INJUSTIFICADA'],
					//['4', 'LICENCIA']
						
			],   
		autoLoad: false 		
	});
	var storeAprobacionHE = new Ext.data.SimpleStore(
	{
		fields: ['codigoex', 'desex'],
		data : [					
								
					['1', 'APROBADO'],
					
						
			],   
		autoLoad: false 		
	});
	var storeHorarioFiltro= new Ext.data.JsonStore(
	{   
	
		url:'../servicesAjax/DSHorarioCBAjax.php',   
		root: 'data',  
		totalProperty: 'total',		
		fields: ['codigop', 'nombrep'],
			
	});		
	storeHorarioFiltro.load();
	var cboHorarioFiltro = new Ext.form.ComboBox(
	{   		
		
		width : 250,
		store: storeHorarioFiltro, 
		mode: 'local',
		autocomplete : true,
		//allowBlank: false,
		style : {textTransform: "uppercase"},
		emptyText:'Horario...',   
		triggerAction: 'all',   		
		displayField:'nombrep',   
		typeAhead: true,
		valueField: 'codigop',
		hiddenName : 'cbHorarioFiltro',
		selectOnFocus: true,
		forceSelection:true,
		listeners: {
					'select': function(cmb,record,index)
							{                        
							
										
							}
							
		}		
	});
		var encode = false;
		var local = true;
		var filters = new Ext.ux.grid.GridFilters({
        // encode and local configuration options defined previously for easier reuse
        encode: encode, // json encode the filter query
        local: local,   // defaults to false (remote filtering)
        filters: [ 
				
				
				<?php
if (!defined('CONEX_LOADED')) {
    define('CONEX_LOADED', true);
    
    date_default_timezone_set('America/La_Paz');
    
    function VerificaConBD()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['BD']) || !$_SESSION['BD']) {
            $_SESSION['BD'] = mysqlii_connect("localhost", "root", "", "madepa");

            if (!$_SESSION['BD'] || mysqlii_connect_errno()) {
                die("Error al conectar con la base de datos (VerificaConBD): " . mysqlii_connect_error());
            }
        }

        return true;
    }

    function ConectarConBD()
    {
        $conexion = mysqlii_connect("localhost", "root", "", "madepa");

        if (!$conexion || mysqlii_connect_errno()) {
            die("Error al conectar con la base de datos (ConectarConBD): " . mysqlii_connect_error());
        }

        mysqlii_set_charset($conexion, "utf8");
        return $conexion;
    }
}
?>

        ]
    }); 
		
   var sm = new Ext.grid.CheckboxSelectionModel(
			{
                singleSelect: false,
                listeners: 
				{
					rowselect: function(sm, row, rec) 
					{                        
						rowIndex = row;							
                    },
					
                }
            });
	////////////////////////////////////////////////////////////////////////////////////
		storeControlAsistencia = new Ext.data.JsonStore({  
			 proxy: new Ext.data.HttpProxy({
					url: '../servicesAjax/DStraerControlAsistenciaEditada.php'
					,timeout: 1000000
					,method: 'POST'
			}),
			root: 'data',   
			
			totalProperty: 'total',  		
			fields: ['marcacionEnt1Edit','marcacionSal1Edit','marcacionEnt2Edit','marcacionSal2Edit','editorRNM','tick1','colorr','codcolor','aprob','color','aprobador',
			'fechaMarcacion1','editorRN','recargoNocturno','editorHE','nHE','HEN','HEF','HED','horasEfectivas','horasdehorario','validador','validacionFaltas',
			'nvalidacionFaltas','nvalidacionRetraso','validacionRetraso','tick','he','hs','he1','hs1','hiem','hism','hfem','hfsm','gestion','mes','dia','codigo','nombre'
			,'horarioOficial','nombreHorario','horario_oficial','IEH','IEM','IFH','IFM','horaEntradaR','minutoEntradaR','segundoEntradaR','marcacion','cod_cargo',
			'nombrecargo','nombrecosto','nombresubcentro','nombreunidad','cod_centro','minuto','horasExtras','minuto1','justificacion','fecha_marcacionEditada',
			'fecha_cambioJustificacion','fechaHorasExtras','fechaAprobarHorasExtras', 'val_hrs_extra'],
			listeners: { 
						load: function(thisStore, record, ids) {
								Ext.Msg.hide();											
							}
					}
			});  	
	////////////////////////////////////////////////////////////////////////////////////
			
		// storeControlAsistencia = new Ext.data.JsonStore({   
			// url: '../servicesAjax/DStraerControlAsistenciaEditada.php',   
			// root: 'data',   
			// totalProperty: 'total',  		
			// fields: ['marcacionEnt1Edit','marcacionSal1Edit','marcacionEnt2Edit','marcacionSal2Edit','editorRNM','tick1','colorr','codcolor','aprob','color','aprobador','fechaMarcacion1','editorRN','recargoNocturno','editorHE','nHE','HEN','HEF','HED','horasEfectivas','horasdehorario','validador','validacionFaltas','nvalidacionFaltas','nvalidacionRetraso','validacionRetraso','tick','he','hs','he1','hs1','hiem','hism','hfem','hfsm','gestion','mes','dia','codigo','nombre','horarioOficial','nombreHorario','horario_oficial','IEH','IEM','IFH','IFM','horaEntradaR','minutoEntradaR','segundoEntradaR','marcacion','cod_cargo','nombrecargo','nombrecosto','nombresubcentro','nombreunidad','cod_centro','minuto','horasExtras','minuto1','justificacion'],
			// listeners: { 		       
					// load: function(thisStore, record, ids) 
					// {  					
						// Ext.Msg.hide();											
					// }
			// }
			
			
		
			// });  	
			
			var Columnas1 = new Ext.ux.grid.LockingColumnModel({ 
			defaults: {
            sortable: true // columns are not sortable by default           
			},
			columns: [	new Ext.grid.RowNumberer({width: 23,locked: true}),
			{  
               header: '<a style =color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;></br></br></br></a>',  
                dataIndex: 'tick',                
				width:25,
                sortable: true,
				renderer: function(value, cell){  
					//alert(value);
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
               header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">CODIGO</a>',  
                dataIndex: 'codigo', 
				renderer: cantidadKit8,					
				width:50,
				align: 'center',
                sortable: true,
				locked: true
            },
			{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">NOMBRE COMPLETO</a>',  
                dataIndex: 'nombre',  
				renderer: cantidadKit8,
                width:180,
                sortable: true ,
				locked: true
			},{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">CARGO</a>',  
				dataIndex: 'nombrecargo', 
				renderer: cantidadKit8,				
                width: 180,
                sortable: true,
				filter: {
                type: 'string'
				}
			},{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">UNIDAD</a>',  
				dataIndex: 'nombreunidad',  
				renderer: cantidadKit8,				
                width: 90,
                sortable: true
			},{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">SUBCENTRO</a>',  
				dataIndex: 'nombresubcentro',
				renderer: cantidadKit8,				
                width: 140,
                sortable: true
			},{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">CENTRO DE COSTO</a>',  
				dataIndex: 'nombrecosto', 
				renderer: cantidadKit8,				
                width: 140,
                sortable: true
			},{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO ASIGNADO</a>',  
				dataIndex: 'nombreHorario',    
                width: 160,
			
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
							
									ind=index;
										save();
									// if(storeControlAsistencia.getAt(rowIndex).get('color')!='b' || parseInt(storeControlAsistencia.getAt(rowIndex).get('aprob'))==1)
									// {
										// ind=index;
										// ActualizarHorario();
									// }
									// else
									// {
									
									// Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">No Se Puede Cambiar Datos</a>');
							
									// }
								}
									  
						}		
                   
                })
              
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO</br> INICIO</a>',  
                dataIndex: 'he', 
				renderer: cantidadKit8,				
                width: 55,
				align: 'center',
                sortable: true
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO</br> SALIDA</a>',  
                dataIndex: 'hs',  
				renderer: cantidadKit8,	
                width: 55,
				align: 'center',
                sortable: true
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO</br> INICIO</a>',  
                dataIndex: 'he1',
				renderer: cantidadKit8,				
                width: 55,
				align: 'center',
                sortable: true
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORARIO</br> SALIDA</a>',  
                dataIndex: 'hs1',  
				renderer: cantidadKit8,
                width: 55,
				align: 'center',
                sortable: true
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">INICIO</a>',  
                dataIndex: 'hiem',  
				renderer: cantidadKit18,
                width: 50,
				align: 'center',
				editor: timeField,
                sortable: true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">SALIDA</a>',  
                dataIndex: 'hism', 
				renderer: cantidadKit19,				
                width: 50,
				align: 'center',
				editor: timeField,
                sortable: true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">INICIO</a>',  
                dataIndex: 'hfem',  
				renderer: cantidadKit20,
                width: 50,
				align: 'center',
				editor: timeField,
                sortable: true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">SALIDA</a>',  
                dataIndex: 'hfsm', 
				renderer: cantidadKit21,				
                width: 50,
				align: 'center',
				editor: timeField,
                sortable: true
			},
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: '',
				width:25,				
				renderer: function(value, cell){  
					
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/save.png' WIDTH='13' HEIGHT='13'></div>";    
					
					return str; 
					
					
				     
				}
				
			},
			{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">MINUTOS DE </BR> RETRASOS </a>',  
                dataIndex: 'minuto', 
				renderer: cantidadKit8,
                width: 70,
				align: 'center',
                sortable: true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">MINUTOS DE </BR> RETRASOS 2 </a>',  
                dataIndex: 'minuto1', 
				renderer: cantidadKit8,
                width: 65,
				align: 'center',
                sortable: true,
				hidden:true
			}
			,{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">RETRASO</a>',  
				dataIndex: 'nvalidacionRetraso',    
                width: 80,
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
							if(storeControlAsistencia.getAt(rowIndex).get('color')!='b' || storeControlAsistencia.getAt(rowIndex).get('aprob')==1)
							{
								if(storeControlAsistencia.getAt(rowIndex).get('minuto')!='F' && storeControlAsistencia.getAt(rowIndex).get('minuto')!='SM' && storeControlAsistencia.getAt(rowIndex).get('hfsm')!='' && storeControlAsistencia.getAt(rowIndex).get('hiem')!='')
								{
									ind1=index;
									if(index==1)
									{
										MotivoAprobacion(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha,0,0,0,storeControlAsistencia.getAt(rowIndex).get('minuto'),storeControlAsistencia.getAt(rowIndex).get('minuto1'));
									}
									else
									{
										 ActualizarJustificacionRetraso();
									}
								}
								else
								{
									alert("POR FAVOR VALIDE EN LA COLUMNA FALTAS");
									Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 storeControlAsistencia.load();
															
								}
							}
							else
							{
							 alert("No Se Puede Cambiar Datos");
							  Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
							 storeControlAsistencia.load();
							}		  
						}	
					}
                   
                })
              
			},{  
                header:'<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">FALTAS</a>',  
				dataIndex: 'nvalidacionFaltas',    
                width: 80,
				renderer: cantidadKit7,
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
								
									if(storeControlAsistencia.getAt(rowIndex).get('color')!='b'|| storeControlAsistencia.getAt(rowIndex).get('aprob')==1)
									{
										if(storeControlAsistencia.getAt(rowIndex).get('minuto')=='F' || storeControlAsistencia.getAt(rowIndex).get('minuto')=='SM' || storeControlAsistencia.getAt(rowIndex).get('hfsm')=='' || storeControlAsistencia.getAt(rowIndex).get('hiem')==''  )
										{
											ind2=index;
											if(index==1)
											{
												apuntador=1;
												MotivoAprobacion(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha,0,0,0);
											}
											else
											{
												if(index==3)
												{
													MotivoAprobacionL(storeControlAsistencia.getAt(rowIndex).get('codigo'));
												}
												else
												{
													
													Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
													if(index==0)
													{
														ActualizarJustificacionFalta();
													}
													if(index==2)
													{
														return Ext.MessageBox.confirm('confirmar','Se enviará la notificación respectiva a Recursos Humanos para elaborar el memorándum correspondiente',
															function(s){
															if(s=='yes'){
																	ActualizarJustificacionFalta();
															}
															else
															{
																storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
																Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
																actualizar();
															}
														 }
														)
														
													}
													
												}
											 }	
										}
										else
										{
											alert("PARA JUSTIFICAR RETRASO EDITE LA MARCACION");
											Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										    storeControlAsistencia.load();
										}
										
									}
									else
									{
									 alert("No Se Puede Cambiar Datos");
									 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
									 storeControlAsistencia.load();
															
									}		 
										
								}
									  
						}		
                   
                })
              
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">VALIDADO POR</a>',  
                dataIndex: 'validador', 
				renderer: cantidadKit8,				
                width:160,
                sortable: true
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">FECHA DE </BR> VALIDACION</a>',  
                dataIndex: 'fecha_marcacionEditada',  
				renderer: cantidadKit8,
                width:100,
				align: 'center',
                sortable: false,
			},
			{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </BR>EXTRAS </BR>SUGERIDAS</a>',  
                dataIndex: 'horasExtras',  
				renderer: cantidadKit8,
                width: 65,
				align: 'center',
                sortable: true
			},
			{                  
				header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </br> EXTRAS </br> NORMAL</a>',  
				dataIndex: 'HEN',
				width: 55,
				align: 'center',
				renderer: cantidadKit6,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false})
				
			},
			{                  
				header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </BR> EXTRAS </BR> FERIADO</a>',  
				dataIndex: 'HEF',
				width: 55,
				align: 'center',
				renderer: cantidadKit6,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false})
				
			},
			{                  
				header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">HORAS </BR> EXTRAS </BR> DOMINGO</a>',  
				dataIndex: 'HED',
				width: 55,
				align: 'center',
				renderer: cantidadKit6,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false})
				
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">RECARGO </BR>NOCTURNO </BR>SUGERIDO </a>',  
                dataIndex: 'editorRNM',  
				renderer: cantidadKit8,
                width:65,
				align: 'center',
                sortable: true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">RECARGO </BR> NOCTURNO </BR> APROBADO</a>',  
                dataIndex: 'editorRN',  
                width:65,
				align: 'center',
				renderer: cantidadKit6,
                sortable: true,
				editor: new fm.NumberField({xtype: 'textfield', allowNegative: false})
			},{    header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">GUARDAR </BR> EDICION</a>',
				dataIndex: 'codigo',
					width: 60,
				//renderer: renderBtn,
				 hidden: true,
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: '',
				width:25,				
				renderer: function(value, cell){  
					
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/save.png' WIDTH='13' HEIGHT='13'></div>";    
					
					return str;  
				}
				
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">EDITOR DE HORAS EXTRAS </BR> Y RECARGO NOCTURNO</a>',  
                dataIndex: 'editorHE',  
				renderer: cantidadKit8,
                width:160,
                sortable: true
			}
			,{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
                dataIndex: '',
				width:25,	
				hidden:true,
				renderer: function(value, cell){  
					
					str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/check.png' WIDTH='13' HEIGHT='13'></div>";    
					
					return str;  
				}
				
			},
			
			{    header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">APROBAR</a>',
				dataIndex: 'color',
					width: 60,
					hidden:true,
				renderer: cantidadKit7
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">FECHA DE </BR> EDICION H.E.</a>',  
                dataIndex: 'fechaHorasExtras',  
				renderer: cantidadKit8,
                width:100,
				align: 'center',
                sortable: false,
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">APROBADOR</a>',  
                dataIndex: 'aprobador',  
				renderer: cantidadKit8,
                width:160,
                sortable: true
			},{  
                header: '<a style ="color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;">FECHA DE </BR> APROBACION</a>',  
                dataIndex: 'fechaAprobarHorasExtras',  
				renderer: cantidadKit8,
                width:100,
				align: 'center',
                sortable: false,
			},
			{  
               header: '<a style =color:#15428B; font: bold 8px tahoma,arial,verdana,sans-serif;></a>',  
                dataIndex: 'tick1',                
				width:0,
                sortable: true,
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
		LlenarMotivoAprobacione = function(fechaap, motivo,tip){
		if(tip==1)
		{
			GuardarArrayVarios(motivo,fechaap);}
		if(tip==2){
			GuardarArrayVariosAprobar(motivo,fechaap);
		}
		if(tip==3){
			GuardarArrayMarcacion(motivo,fechaap);
		}
		
		}	
		
		function cantidadKit8(value, metadata, record, rowIndex, colIndex, store) {  
		
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
		LlenarMotivoAprobacion = function(fechaap, motivoap,motivog2,motivog3,ban,valor,fechaAprobar,minutosj){
			if(ban==0){
			Aprobar(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha, fechaap, motivoap,motivog2,motivog3,minutosj);}
			if(ban==1){
			Aprobar(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha, fechaap, motivoap,motivog2,motivog3);
			horasextras(valor);}
			if(ban==2){
			Aprobar(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha, fechaap, motivoap,motivog2,motivog3);
			aprobada(valor,fechaAprobar);}
		}
		function Aprobar(idSel,fechaj, fechaap, motivoap,motivog2,motivog3,minutosj){

			Ext.Ajax.request({  
            url: '../servicesAjax/DSAprobarJustificacionAJAX.php',  
			timeout: 1000000,
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
							
								}
						else{alert("NO TIENE GLOZA");}
			}  
      
			function no_desactivo(resp)  
			{  			
				Ext.MessageBox.alert('Mensaje', resp.mensaje);  
			}  
        }
		function cantidadKit18(value, metadata, record, rowIndex, colIndex, store) {  
			if (record.data['marcacionEnt1Edit'] == 1){
			metadata.attr = 'style="font-size:8px;background-color: #FF9966"';    
			 return value; 
			 }
			 else
			 {
				metadata.attr = 'style="background-color:#CAFF70;font-size:8px;"';    
				return value;     
			 
			 }
		}
		function cantidadKit19(value, metadata, record, rowIndex, colIndex, store) {  
			if (record.data['marcacionSal1Edit'] == 1){
			metadata.attr = 'style="font-size:8px;background-color: #FF9966"';    
			 return value; 
			 }
			 else
			 {
				metadata.attr = 'style="background-color:#CAFF70;font-size:8px;"';    
				return value;     
			 
			 }
		}
		function cantidadKit20(value, metadata, record, rowIndex, colIndex, store) {  
			if (record.data['marcacionEnt2Edit'] == 1){
			metadata.attr = 'style="font-size:8px;background-color: #FF9966"';    
			 return value; 
			 }
			 else
			 {
				metadata.attr = 'style="background-color:#CAFF70;font-size:8px;"';    
				return value;     
			 
			 }
		}
			function cantidadKit21(value, metadata, record, rowIndex, colIndex, store) {  
			if (record.data['marcacionSal2Edit'] == 1){
			metadata.attr = 'style="font-size:8px;background-color: #FF9966"';    
			 return value; 
			 }
			 else
			 {
				metadata.attr = 'style="background-color:#CAFF70;font-size:8px;"';    
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
				timeout: 1000000,
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
	function aprobada(valor,fecha)
	{
				GuardarAprobador(valor,fecha);
				storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
				 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
				 window.setTimeout(function()
				 {
					 Ext.Msg.hide();							  
																   /*********************/
					 storeControlAsistencia.load();
					   
															   /********************/
				},3000);
	}
	function createGridButton1(value, contentid, record) {
			new Ext.Button({text: 'APROBAR', handler : function(btn, e) {
			if(storeControlAsistencia.getAt(rowIndex).get('tick')!=1)
			{
			
				if(storeControlAsistencia.getAt(rowIndex).get('color')!='b')
				{
				MotivoAprobacion(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha,0,2,value);
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
	function horasextras(valor)
	{
		if(storeControlAsistencia.getAt(rowIndex).get('horasExtras')!="F")
				{
					GuardarArray1(valor);
				}
									
			 storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
			 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			 window.setTimeout(function()
			 {
				 Ext.Msg.hide();							  
															   /*********************/
				 storeControlAsistencia.load();
					   
															   /********************/
			},3000);
	}
  function createGridButton(value, contentid, record) {
   new Ext.Button({text: 'GUARDAR', handler : function(btn, e) {
   
			if(storeControlAsistencia.getAt(rowIndex).get('color')!='b' || storeControlAsistencia.getAt(rowIndex).get('aprob')==1)
			{
				if(storeControlAsistencia.getAt(rowIndex).get('horasExtras')!='F')
				{
					MotivoAprobacion(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha,0,1,value);
				}
				else
				{
					alert("No Se Puede Guardar Datos Cuando es Falta");
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					 window.setTimeout(function()
					 {
						 Ext.Msg.hide();							  
																	   /*********************/
						 storeControlAsistencia.load();
							   
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
						 storeControlAsistencia.load();
							   
																	   /********************/
					},3000);
			}
   }}).render(document.body, contentid);
  }
	 function reload()
		  {
								ActualizarJustificacionFalta();
												
		  }
		function ActualizarHE(registros,value)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarHE.php',
				timeout: 1000000,
				method:'POST',
				params:{registros:registros,codigo:value,fecha:fecha},
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
		function actualizarM(fechaM,codTrabajador)
		{
			var tick;var justificacion;var nombreHorario;var he;var hs;var he1;var hs1;var hiem;var hism;var hfem;var hfsm;var minuto;var nvalidacionFaltas;
			var validador;var horasExtras;var HEN;var HEF;var HED;var editorRNM;var editorRN;var editorHE;var aprobador;
			storeControlAsistencia1 = new Ext.data.JsonStore({   
				 proxy: new Ext.data.HttpProxy({
						url: '../servicesAjax/DStraerControlAsistenciaEditadaP.php'
						,timeout: 1000000
						,method: 'POST'
				}),
				root: 'data',   
				totalProperty: 'total',  		
				fields: ['marcacionEnt1Edit','marcacionSal1Edit','marcacionEnt2Edit','marcacionSal2Edit','editorRNM','colorr','codcolor','aprob',
				'color','aprobador','editorRN','recargoNocturno','editorHE','nHE','HEN','HEF','HED','horasEfectivas','horasdehorario','validador',
				'validacionFaltas','nvalidacionFaltas','nvalidacionRetraso','validacionRetraso','tick','Ndia','he','hs','he1','hs1','hiem','hism','hfem',
				'hfsm','gestion','mes','dia','codigo','nombre','horarioOficial','nombreHorario','horario_oficial','IEH','IEM','IFH','IFM','horaEntradaR',
				'minutoEntradaR','segundoEntradaR','marcacion','cod_cargo','nombrecargo','nombrecosto','nombresubcentro','nombreunidad','cod_centro','minuto',
				'horasExtras','fechaMarcacion','fechaMarcacion1','minuto1','justificacion','fecha_marcacionEditada',
				'fecha_cambioJustificacion','fechaHorasExtras','fechaAprobarHorasExtras'],
				listeners: { 		       
						load: function(thisStore, record, ids) 
						{  	
						
							tick=record[0].data.tick;
							justificacion=record[0].data.justificacion;
							nombreHorario=record[0].data.nombreHorario;
							he=record[0].data.he;
							hs=record[0].data.hs;
							he1=record[0].data.he1;
							hs1=record[0].data.hs1;
							hiem=record[0].data.hiem;
							hism=record[0].data.hism;
							hfem=record[0].data.hfem;
							hfsm=record[0].data.hfsm;
							
							minuto=record[0].data.minuto;
							nvalidacionFaltas=record[0].data.nvalidacionFaltas;
							validador=record[0].data.validador;
							horasExtras=record[0].data.horasExtras;
							HEN=record[0].data.HEN;
							HEF=record[0].data.HEF;
							HED=record[0].data.HED;
							editorRNM=record[0].data.editorRNM;
							editorRN=record[0].data.editorRN;
							editorHE=record[0].data.editorHE;
							aprobador=record[0].data.aprobador;
							
							fecha_marcacionEditada=record[0].data.fecha_marcacionEditada;
							fecha_cambioJustificacion=record[0].data.fecha_cambioJustificacion;
							fechaHorasExtras=record[0].data.fechaHorasExtras;
							fechaAprobarHorasExtras=record[0].data.fechaAprobarHorasExtras;
							
							actualizarGrillaM(tick,justificacion,nombreHorario,he,hs,he1,hs1,hiem,hism,hfem,hfsm,minuto,nvalidacionFaltas,validador,horasExtras,HEN,HEF,HED,editorRNM,editorRN,editorHE,aprobador,fechaM,codTrabajador,fecha_marcacionEditada,fecha_cambioJustificacion,fechaHorasExtras,fechaAprobarHorasExtras);
															
						}
				}
				
			});  	
				storeControlAsistencia1.baseParams['fechai'] = fechaM;
					storeControlAsistencia1.baseParams['rdirecto'] = rdirecto;
					storeControlAsistencia1.baseParams['rextendido'] =rextendido;
					storeControlAsistencia1.baseParams['filtro'] = filtro;
					storeControlAsistencia1.baseParams['codigo'] =codTrabajador;
					storeControlAsistencia1.load();		
		}
		function actualizarGrillaM(tick,justificacion,nombreHorario,he,hs,he1,hs1,hiem,hism,hfem,hfsm,minuto,nvalidacionFaltas,validador,horasExtras,HEN,HEF,HED,editorRNM,editorRN,editorHE,aprobador,fechaM,codTrabajador,fecha_marcacionEditada,fecha_cambioJustificacion,fechaHorasExtras,fechaAprobarHorasExtras)
		{
			
				this.GridControlAsistencia.el.mask('Guardando', 'x-mask-loading'); //step 3
				this.GridControlAsistencia.stopEditing();
				
				
					storeControlAsistencia.each(function(record){
									if(record.data.codigo ==codTrabajador){
										
										record.data.tick=tick;
										record.data.justificacion=justificacion;
										record.data.nombreHorario=nombreHorario;
										record.data.he=he;
										record.data.hs=hs;
										record.data.he1=he1;
										record.data.hs1=hs1;
										
										record.data.hiem=hiem;
										record.data.hism=hism;
										record.data.hfem=hfem;
										record.data.hfsm=hfsm;
										
										record.data.minuto=minuto;
										record.data.nvalidacionFaltas=nvalidacionFaltas;
										record.data.validador=validador;
										record.data.horasExtras=horasExtras;
										record.data.HEN=HEN;
										record.data.HEF=HEF;
										
										record.data.HED=HED;
										record.data.editorRNM=editorRNM;
										
										record.data.editorRN=editorRN;
										record.data.editorHE=editorHE;
										record.data.aprobador=aprobador;
										
										
										record.data.fecha_marcacionEditada=fecha_marcacionEditada;
										record.data.fecha_cambioJustificacion=fecha_cambioJustificacion;
										record.data.fechaHorasExtras=fechaHorasExtras;
										record.data.fechaAprobarHorasExtras=fechaAprobarHorasExtras;
									}
									
								});
			this.GridControlAsistencia.el.unmask();
			this.GridControlAsistencia.getStore().commitChanges();
			this.GridControlAsistencia.getView().refresh();	
			
		}
		function ActualizarMarcacionEditada(registros,motivo,fechaap)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarMarcacionesVarios.php',
				timeout: 1000000,
				method:'POST',
				params:{registros:registros,fecha:fecha,motivo:motivo,fechaap:fechaap},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
				
						filtro=cboHorarioFiltro.getRawValue();
						storeControlAsistencia.baseParams['fechai'] = fecha;
						storeControlAsistencia.baseParams['filtro'] = filtro;
						 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
						var modified = this.GridControlAsistencia.getStore().getModifiedRecords();//step 1
							if(!Ext.isEmpty(modified)){
								
								var recordsToSend = [];
								Ext.each(modified, function(record) { //step 2
								
									actualizarM(record.data.fechaMarcacion1,record.data.codigo);
									
								});

								 Ext.Msg.hide();	
								
							}	
							 Ext.Msg.hide();
					//	storeControlAsistencia.load();

				}
				function no_desactivo(resp)
				{
					
					 Ext.Msg.hide();
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
		}
		function ActualizarHETodas(registros,motivo,fechaap)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarHEVarios.php',
				timeout: 1000000,
				method:'POST',
				params:{registros:registros,fecha:fecha,motivo:motivo,fechaap:fechaap},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
						
						
						filtro=cboHorarioFiltro.getRawValue();
						storeControlAsistencia.baseParams['fechai'] = fecha;
						storeControlAsistencia.baseParams['filtro'] = filtro;
						 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
						var modified = this.GridControlAsistencia.getStore().getModifiedRecords();//step 1
							if(!Ext.isEmpty(modified)){
								
								var recordsToSend = [];
								Ext.each(modified, function(record) { //step 2
								
									actualizarM(record.data.fechaMarcacion1,record.data.codigo);
									
								});

								 Ext.Msg.hide();	
								
							}	
						 Ext.Msg.hide();
						 var data = Ext.util.JSON.decode(resp.responseText);
					
						Ext.Msg.alert('Mensaje', data.message.reason, function()
						{
							//storeControlAsistencia.load();
						});

				}
				function no_desactivo(resp)
				{
					 Ext.Msg.hide();
				}
		}
		function ActualizarHETodas1(registros,motivo,fechaap)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarAprobadorVarios.php',
				timeout: 1000000,
				method:'POST',
				params:{registros:registros,fecha:fecha,motivo:motivo,fechaap:fechaap},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					filtro=cboHorarioFiltro.getRawValue();
					storeControlAsistencia.baseParams['fechai'] = fecha;
					storeControlAsistencia.baseParams['filtro'] = filtro;
					  Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 // window.setTimeout(function()
										 // {
										   // Ext.Msg.hide();							  
													   // /*********************/
												
													// // storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
												
			   
													   // /********************/
										 // },6000);	
					storeControlAsistencia.load();
					// Ext.dsdata.storeCliente.load({params:{start:0,limit:25	}});	

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
		}
   	var Paginas = new Ext.PagingToolbar({
			pageSize: 500,  
			store: storeControlAsistencia,  
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

		function AlertaHrsExtras(t_he, op_motivo){
		// var mensaje_he = ""
		if(t_he >= 24){
			if(t_he <= 35){
				Ext.Msg.alert('Mensaje', 'El sistema le hace notar que ha alcanzado y/o sobrepasado el 50% de las Horas Extras permitidas legales. Favor tener en cuenta.', function(){
					MotivoApro(op_motivo);
				});	
			}
			else if(t_he <= 44){
				Ext.Msg.alert('Mensaje', 'El sistema le hace notar que ha alcanzado y/o sobrepasado el 75% de las Horas Extras permitidas legales. Favor tener en cuenta.', function(){
					MotivoApro(op_motivo);
				});
			}
			else if(t_he <= 48){
				Ext.Msg.alert('Mensaje', 'El sistema le hace notar que ha alcanzado el límite del permitido legal en Horas Extras. No está permitido sobrepasar este límite.', function(){
					MotivoApro(op_motivo);
				});
			}
			else if(t_he <= 59){
				Ext.Msg.alert('Mensaje', 'El sistema le hace notar que se ha excedido de sobremanera el permitido legal de Horas Extraordinarias. Esto es una infracción legal.', function(){
					MotivoApro(op_motivo);
				});
			}
			else{
				Ext.Msg.alert('Mensaje', 'El sistema le hace notar que se ha excedido de sobremanera el permitido legal de Horas Extraordinarias. Esto es una infracción legal y atenta a la seguridad de las personas.', function(){
					MotivoApro(op_motivo);
				});
			}
		}else{
			MotivoApro(op_motivo);
		}
		

		// return mensaje_he;
	}
			
	var GridControlAsistencia = new Ext.grid.EditorGridPanel({  
		id: 'gridAsistencia',
		region:'center',
		loadMask: true,
		// height : 500,
		store: storeControlAsistencia,
		cm: Columnas1,
		columnLines: true,
		bbar: Paginas, 
		sm: sm,
		listeners:
		{
				
			'cellclick' : function(grid, rowIndex, cellIndex, e){
					var store = grid.getStore().getAt(rowIndex);
					var columnName = grid.getColumnModel().getDataIndex(cellIndex);
					var cellValue = store.get(columnName);
					if(cellIndex==2)
					{
						var auxi=0;
						fecha1=fechaini.getValue().format('Y-m-d');
						MotivoAprobacion(storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha1,auxi,0,0);//ExportaraExcel(); 
					}
					if(cellIndex==18)
					{
						MotivoApro(3);
						console.log("revision HRS extra: celda 18");
					}
					if(cellIndex==32)
					{
						MotivoApro(1);
						//	var HEN_val = storeControlAsistencia.getAt(rowIndex).get('HEN');
						//	var HEF_val = storeControlAsistencia.getAt(rowIndex).get('HEF');
						//	var HED_val = storeControlAsistencia.getAt(rowIndex).get('HED');
							
						//	var HEN_val = parseFloat(HEN_val==""?0:HEN_val);
						//	var HEF_val = parseFloat(HEF_val==""?0:HEF_val);
						//	var HED_val = parseFloat(HED_val==""?0:HED_val);
							
							
						//	var total_HE_val = HEN_val + HEF_val + HED_val;
						//	console.log("revision HRS extra: " + total_HE_val);
						//	AlertaHrsExtras(total_HE_val, 1);
					}
					if(cellIndex==34)
						{
						console.log("revision HRS extra: celda 34");
						MotivoApro(2);
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
					alert("hola");
					alert(row.get('color'));
					//alert();
					if(row.get('colorr') == 'y' ){
						cls = 'ColorAmarilo';
					}
					if(row.get('colorr') == 'SI' ){
						cls = 'ColorAzul';
					}
					if(row.get('colorr') == 'r' ){
						cls = 'ColorRojo';
					}
					
					return cls; 
				 },
							 
			},
			stateful: true,
			plugins: [filters],
		});			
	var storeGrupos= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaGrupoFiltroCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigog', 'nombreg']			
		});		
		storeGrupos.load();

		var filterInicial = new Ext.form.ComboBox(
		{   	
			hidden:true,
			// x: 140,
			// y: 105,		
			width : 120,
			store: storeGrupos, 
			mode: 'local',
			//autocomplete : true,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Grupos...',   
			triggerAction: 'all',   		
			displayField:'nombreg',   
			//typeAhead: true,
			valueField: 'codigog',
			hiddenName : 'filterInicial',
		//	selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
						if(e.getKey()==13){
							// cboGenero.focus(true, 300);
						}
					}
						  
			}		
		});	
		var bfilterinicial = new Ext.Toolbar.Button({
			text: 'Filtrar',
			//tooltip: "Utilizar '*' para busquedas ",  
			icon: '../img/view.png',
			handler: function(btn,e) {		
				var filtrado = filterInicial.getValue();
				var fechiniv;
				if (fechaini.getValue() > 0)
					{fechiniv = fechaini.getValue().format('Y-m-d');}
				else
					{fechiniv = '';}
				
				
				if( fechiniv.length > 0 )
				{  
					var o = {start : 0, limit:100};					
					filtro=cboHorarioFiltro.getRawValue();
					//alert(filtro);
					storeControlAsistencia.baseParams['fechai'] = fechiniv;
					storeControlAsistencia.baseParams['filtro'] = filtro;
					//storeControlAsistencia.baseParams['fechaf'] = fechfinv;
					storeControlAsistencia.baseParams['grupo'] = filtrado;
				
					//frmControlAsistencia.guardarDatos();
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					
					storeControlAsistencia.reload({params:o});
					
		
				} else {
					storeControlAsistencia.clearFilter();
				}	
				fecha=fechaini.getValue().format('Y-m-d');
				////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
			}
		});
		
	   GridControlAsistencia.getBottomToolbar().add(
		[        
			 '->',filterInicial,bfilterinicial, '-'
		]);
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
				winControlAsistencia.hide();
			} 
		});	
		
		function Resetear()
		{ 
		
			GridControlAsistencia.removeAll();
			registrosGrid1=0;
		}	
		
		function GuardarArray1(value) { 
			var store = Ext.getCmp("gridAsistencia").getStore();
		
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
		function GuardarArrayVariosAprobar(motivo1,fechaap) { 
			
			var datosGrid = [];  
			sm.each(function(rec){         
			datosGrid.push(Ext.apply({id:rec.id},rec.data));            
			});    
			registrosGrid = Ext.encode(datosGrid);
			ActualizarHETodas1(registrosGrid,motivo1,fechaap);	
		}; 	
		function GuardarArrayVarios(motivo1,fechaap) { 
			// var store = Ext.getCmp("gridAsistencia").getStore();
			// var datosGrid1 = []; 
			// var i=0;			
			// store.each(function(rec){                                                       
				// datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
						// i++;
   			// });    	
			var datosGrid1 = []; 
			var i=0;
			var modified = this.GridControlAsistencia.getStore().getModifiedRecords();//step 1
			var msjHRS_extra= "ok";
			var cont_hrs_extra = 0;
			if(!Ext.isEmpty(modified)){
				
				var recordsToSend = [];
				Ext.each(modified, function(record) { //step 2
					var HEN_val = record.data.HEN;
					 var HEF_val = record.data.HEF;
					 var HED_val = record.data.HED;
					 HEN_val = parseFloat(HEN_val==""?0:HEN_val);
					 HEF_val = parseFloat(HEF_val==""?0:HEF_val);
					 HED_val = parseFloat(HED_val==""?0:HED_val);


					var hrs_extra_acu = parseFloat(record.data.val_hrs_extra);
					var hrs_extra_actu =  parseFloat(HEN_val) + parseFloat(HEF_val) + parseFloat(HED_val);
					var total_hrs_extra = 	parseFloat(hrs_extra_acu) + parseFloat(hrs_extra_actu);
					console.log(total_hrs_extra);
					if(total_hrs_extra > 53){
						cont_hrs_extra++;
						console.log(msjHRS_extra);
						if(cont_hrs_extra == 1){
							msjHRS_extra = "<B>El Sistema ha detectado que el siguiente personal excede el permitido legal de Horas Extras y no permitirá continuar. Favor revisar.<br> "+cont_hrs_extra+") </B>" + record.data.nombre;
						}else{
							msjHRS_extra = msjHRS_extra + "<br> <B>"+cont_hrs_extra+") </b>" + record.data.nombre;
						}
					}
					datosGrid1.push(Ext.apply({id:record.id},record.data)); 
					i++;
				});
			}
			Ext.Msg.hide();
			if(msjHRS_extra == "ok"){
				registrosGrid2 = Ext.encode(datosGrid1);
				//alert(registrosGrid2);
				ActualizarHETodas(registrosGrid2,motivo1,fechaap);
			}else{
				Ext.Msg.alert('Mensaje de Alerta', msjHRS_extra, function(){});
			}
		}; 	
		function GuardarArrayMarcacion(motivo1,fechaap) { 
			 //Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			// var store = Ext.getCmp("gridAsistencia").getStore();
			// var datosGrid1 = []; 
			// var i=0;			
			// store.each(function(rec){                                                       
				// datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
						// i++;
   			// });    	
			var datosGrid1 = []; 
			var i=0;
			var modified = this.GridControlAsistencia.getStore().getModifiedRecords();//step 1
			if(!Ext.isEmpty(modified)){
				
				var recordsToSend = [];
				Ext.each(modified, function(record) { //step 2
				datosGrid1.push(Ext.apply({id:record.id},record.data)); 
				i++;
				});

				
			}
			Ext.Msg.hide();
			registrosGrid2 = Ext.encode(datosGrid1);
			//alert (registrosGrid2);
		ActualizarMarcacionEditada(registrosGrid2,motivo1,fechaap);
		}; 	
		
		var fechaini = new Ext.form.DateField({
		name: 'fecha1',
		hideLabel: true, 
		maxLength : 10,
		width: 91,
			
		format : 'd/m/Y',
		//allowBlank: true,		
		enableKeyEvents: true,
		selectOnFocus: true,
		cls:"name",
		listeners: {
						specialkey: function(f,e){
								if(e.getKey() == e.ENTER){
												var fechiniv;
												if (fechaini.getValue() > 0)
													{fechiniv = fechaini.getValue().format('Y-m-d');}
												else
													{fechiniv = '';}
												
												
												if( fechiniv.length > 0 )
												{  
													var o = {start : 0, limit:100};					
													filtro=cboHorarioFiltro.getRawValue();
													//alert(filtro);
													storeControlAsistencia.baseParams['fechai'] = fechiniv;
													storeControlAsistencia.baseParams['filtro'] = filtro;
													//storeControlAsistencia.baseParams['fechaf'] = fechfinv;
												
													//frmControlAsistencia.guardarDatos();
													 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
													
													storeControlAsistencia.reload({params:o});
													
										
												} else {
													storeControlAsistencia.clearFilter();
												}	
												fecha=fechaini.getValue().format('Y-m-d');
							}
						}
					}
		});		
		
		var bfilter = new Ext.Toolbar.Button(
		{
			text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Buscar</a>',
			tooltip: "Utilizar '*' para busquedas ",       		
			icon: '../img/view.png',
			handler: function(btn,e) {
				var filtrado = filterInicial.getValue();
				var fechiniv;
				if (fechaini.getValue() > 0)
					{fechiniv = fechaini.getValue().format('Y-m-d');}
				else
					{fechiniv = '';}
				
				
				if( fechiniv.length > 0 )
				{  
					var o = {start : 0, limit:100};					
					filtro=cboHorarioFiltro.getRawValue();
					//alert(filtro);
					storeControlAsistencia.baseParams['fechai'] = fechiniv;
					storeControlAsistencia.baseParams['filtro'] = filtro;
					//storeControlAsistencia.baseParams['fechaf'] = fechfinv;
					storeControlAsistencia.baseParams['grupo'] = filtrado;
				
					//frmControlAsistencia.guardarDatos();
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					
					storeControlAsistencia.reload({params:o});
					
		
				} else {
					storeControlAsistencia.clearFilter();
				}	
				fecha=fechaini.getValue().format('Y-m-d');
				
			}
		});	
				
		var frmControlAsistencia = new Ext.FormPanel({ 
			frame:true, 
			//selectOnFocus: true,
			//layout: 'absolute',
			// width: 1120,
			height: 400,
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
							storeControlAsistencia.reload();
							//Ext.MessageBox.alert('MSG', 'CAMBIOS GUARDADOS'); 
							//storeControlAsistencia.load({params:{idcliente:codcliente1,idproyecto:codproyecto1,idmes:codmes1,idgestion:codgestion1}});
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
			var store = Ext.getCmp("gridAsistencia").getStore();
		
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
			storeexcel = new Ext.data.JsonStore({  
			 proxy: new Ext.data.HttpProxy({
					url:'../servicesAjax/DSpasar.php'
					,timeout: 1000000
					,method: 'POST'
			}),
			root: 'data',   
			
			totalProperty: 'total',  		
			fields: ['codigo','descripcion'],
			listeners: { 
						load: function(thisStore, record, ids) {
						//alert("v");
									location = "../servicesAjax/DSExcelControlAsistenciaEditada.php?fecha="+fecha;  
									
			 Ext.Msg.hide();
							}
					}
			}); 
			storeexcel.baseParams['reg'] =registrosGridexcel;
			storeexcel.load();	
					

		}
		function ExportaraExcel1()
		{
					Ext.Ajax.request({
					url:'../servicesAjax/DSpasar.php',
					timeout: 1000000,
					method:'POST',
					params:{reg:registrosGridexcel},
					success:desactivo,
					failures:no_desactivo
					});
				
					function desactivo(resp)
					{
						
						location = "../servicesAjax/DSExcelControlAsistenciaEditada.php?fecha="+fecha;  

					}
					function no_desactivo(resp)
					{
						//Ext.MessageBox.alert('mensaje', resp.mensaje);
					}

		}
		function GuardarArrayVariosRevisado() { 
			
				var datosGrid = [];  
						sm.each(function(rec){         
							
							datosGrid.push(Ext.apply({id:rec.id},rec.data));            
						});    
						registrosGrid = Ext.encode(datosGrid);
					
			ActualizarRevision(registrosGrid);
			
		};
		function ActualizarRevision(registros)
		{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSguardarRevisionVarios.php',
				timeout: 1000000,
				method:'POST',
				params:{registros:registros},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					storeControlAsistencia.baseParams['fechai'] = fechaini.getValue();
					storeControlAsistencia.baseParams['filtro'] = filtro;
					
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										
											
					storeControlAsistencia.load();
				

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
		}
		var PAmenu = new Ext.Panel(
		{
			region: 'north',
			id: 'PAcabecera1',
			height: 29,   
			tbar: [
					chkdirectos,'-',chkextendido,'-',
				
					{
						text: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Descargar</a>',
						icon: '../img/excel.png',
						handler: function confirm() 
						{		
								Ext.Msg.wait('Descargando.. Espere por favor!');
							Registro();
							ExportaraExcel(); 
						}
					},"->",
					
					// {
								// text: 'Revisado',
								// icon: '../img/check.png',
								// handler: function confirm() 
								// {					
									// GuardarArrayVariosRevisado() ;
								// }
					// },'-',
						fechaini, '-', bfilter	
					
																	
				]
			});		
			function save()
			{
				 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
								
				Ext.Ajax.request({ 		// step 5
						url:'../servicesAjax/DSValidarControlAsistencia.php',
						params:{horario:storeHorario.getAt(ind).get('codigop'),codigo:storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha:fecha},
						scope:this,
						success : function(response) { //step 6
							
						
						
							actualizar();
								
						}
					});
				
					
			
			}
			function actualizar()
			{
				var fechaM;
				storeControlAsistencia.each(function(record){
					if(record.data.fechaMarcacion1 == storeControlAsistencia.getAt(rowIndex).get('fechaMarcacion1')){
						
						fechaM=storeControlAsistencia.getAt(rowIndex).get('fechaMarcacion1')
						
					}
					
				});
				var tick;var justificacion;var nombreHorario;var he;var hs;var he1;var hs1;var hiem;var hism;var hfem;var hfsm;var minuto;var nvalidacionFaltas;
				var validador;var horasExtras;var HEN;var HEF;var HED;var editorRNM;var editorRN;var editorHE;var aprobador;
				
				storeControlAsistencia1 = new Ext.data.JsonStore({  
				 proxy: new Ext.data.HttpProxy({
						url: '../servicesAjax/DStraerControlAsistenciaEditadaP.php'
						,timeout: 1000000
						,method: 'POST'
				}),
				root: 'data',   
				
				totalProperty: 'total',  		
				fields: ['marcacionEnt1Edit','marcacionSal1Edit','marcacionEnt2Edit','marcacionSal2Edit','editorRNM','tick1','colorr',
				'codcolor','aprob','color','aprobador','fechaMarcacion1','editorRN','recargoNocturno','editorHE','nHE','HEN','HEF','HED',
				'horasEfectivas','horasdehorario','validador','validacionFaltas','nvalidacionFaltas','nvalidacionRetraso','validacionRetraso',
				'tick','he','hs','he1','hs1','hiem','hism','hfem','hfsm','gestion','mes','dia','codigo','nombre','horarioOficial','nombreHorario',
				'horario_oficial','IEH','IEM','IFH','IFM','horaEntradaR','minutoEntradaR','segundoEntradaR','marcacion','cod_cargo','nombrecargo',
				'nombrecosto','nombresubcentro','nombreunidad','cod_centro','minuto','horasExtras','minuto1','justificacion','fecha_marcacionEditada',
				'fecha_cambioJustificacion','fechaHorasExtras','fechaAprobarHorasExtras'
				],
				listeners: { 
							load: function(thisStore, record, ids) {
									tick=record[0].data.tick;
									justificacion=record[0].data.justificacion;
									nombreHorario=record[0].data.nombreHorario;
									he=record[0].data.he;
									hs=record[0].data.hs;
									he1=record[0].data.he1;
									hs1=record[0].data.hs1;
									hiem=record[0].data.hiem;
									hism=record[0].data.hism;
									hfem=record[0].data.hfem;
									hfsm=record[0].data.hfsm;
									
									minuto=record[0].data.minuto;
									nvalidacionFaltas=record[0].data.nvalidacionFaltas;
									validador=record[0].data.validador;
									horasExtras=record[0].data.horasExtras;
									HEN=record[0].data.HEN;
									HEF=record[0].data.HEF;
									HED=record[0].data.HED;
									editorRNM=record[0].data.editorRNM;
									editorRN=record[0].data.editorRN;
									editorHE=record[0].data.editorHE;
									aprobador=record[0].data.aprobador;
									
									fecha_marcacionEditada=record[0].data.fecha_marcacionEditada;
									fecha_cambioJustificacion=record[0].data.fecha_cambioJustificacion;
									fechaHorasExtras=record[0].data.fechaHorasExtras;
									fechaAprobarHorasExtras=record[0].data.fechaAprobarHorasExtras;
									actualizarGrilla(tick,justificacion,nombreHorario,he,hs,he1,hs1,hiem,hism,hfem,hfsm,minuto,nvalidacionFaltas,validador,horasExtras,HEN,HEF,HED,editorRNM,editorRN,editorHE,aprobador,fecha_marcacionEditada,fecha_cambioJustificacion,fechaHorasExtras,fechaAprobarHorasExtras);											
								}
						}
				});  	
					storeControlAsistencia1.baseParams['fechai'] = fechaM;
					storeControlAsistencia1.baseParams['rdirecto'] = rdirecto;
					storeControlAsistencia1.baseParams['rextendido'] =rextendido;
					storeControlAsistencia1.baseParams['filtro'] = filtro;
					storeControlAsistencia1.baseParams['codigo'] =storeControlAsistencia.getAt(rowIndex).get('codigo');
					storeControlAsistencia1.load();		
					
			}
			function actualizarGrilla(tick,justificacion,nombreHorario,he,hs,he1,hs1,hiem,hism,hfem,hfsm,minuto,nvalidacionFaltas,validador,horasExtras,HEN,HEF,HED,editorRNM,editorRN,editorHE,aprobador,fecha_marcacionEditada,fecha_cambioJustificacion,fechaHorasExtras,fechaAprobarHorasExtras)
		{
			
				var modified = this.GridControlAsistencia.getStore().getModifiedRecords();//step 1
				var recordsToSend = [];
				Ext.each(modified, function(record) { //step 2
					recordsToSend.push(Ext.apply({id:record.id},record.data));
				});

				this.GridControlAsistencia.el.mask('Guardando', 'x-mask-loading'); //step 3
				this.GridControlAsistencia.stopEditing();
				recordsToSend = Ext.encode(recordsToSend); //step 4
				
					storeControlAsistencia.each(function(record){
									if(record.data.codigo == storeControlAsistencia.getAt(rowIndex).get('codigo')){
										
										record.data.tick=tick;
										record.data.justificacion=justificacion;
										record.data.nombreHorario=nombreHorario;
										record.data.he=he;
										record.data.hs=hs;
										record.data.he1=he1;
										record.data.hs1=hs1;
										
										record.data.hiem=hiem;
										record.data.hism=hism;
										record.data.hfem=hfem;
										record.data.hfsm=hfsm;
										
										record.data.minuto=minuto;
										record.data.nvalidacionFaltas=nvalidacionFaltas;
										record.data.validador=validador;
										record.data.horasExtras=horasExtras;
										record.data.HEN=HEN;
										record.data.HEF=HEF;
										
										record.data.HED=HED;
										record.data.editorRNM=editorRNM;
										
										record.data.editorRN=editorRN;
										record.data.editorHE=editorHE;
										
										record.data.aprobador=aprobador;
									
									
										record.data.fecha_marcacionEditada=fecha_marcacionEditada;
										record.data.fecha_cambioJustificacion=fecha_cambioJustificacion;
										record.data.fechaHorasExtras=fechaHorasExtras;
										record.data.fechaAprobarHorasExtras=fechaAprobarHorasExtras;
										Ext.Msg.hide();		
									}
									
								});
			this.GridControlAsistencia.el.unmask();
			this.GridControlAsistencia.getStore().commitChanges();
		}
			function ActualizarHorario()
			{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSValidarControlAsistencia.php',
				timeout: 1000000,
				method:'POST',
				params:{horario:storeHorario.getAt(ind).get('codigop'),codigo:storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha:fecha},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
						storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
										Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');							  
												storeControlAsistencia.load();
	
												

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
			}
			function ActualizarJustificacionRetraso()
			{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSValidarRetraso.php',
				timeout: 1000000,
				method:'POST',
				params:{validarRetraso:storeValidacionRetraso.getAt(ind1).get('codigoex'),codigo:storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha:fecha},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					 storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
										 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
									     storeControlAsistencia.load();
				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
			}
			function ActualizarJustificacionFalta()
			{
			
				Ext.Ajax.request({
				url:'../servicesAjax/DSValidarFalta.php',
				timeout: 1000000,
				method:'POST',
				params:{validarFalta:storeValidacionFaltas.getAt(ind2).get('codigoex'),codigo:storeControlAsistencia.getAt(rowIndex).get('codigo'),fecha:fecha},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
													Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
													  							  
															 actualizar();	
															
															
													

				}
				function no_desactivo(resp)
				{
					// Ext.MessageBox.alert('mensaje', resp.mensaje);
				}
			}
		
		function IngresarControlAsistencia($conex)
		{	
			var viewport1 = new Ext.Viewport(
			{
				layout: 'border',
							
				items: [PAmenu,GridControlAsistencia]
			}); 
			
			var fechaActual = new Date()
			fechaini.setValue(fechaActual);
			fecha=fechaActual.format('Y-m-d');
			
			storeControlAsistencia.baseParams['filtro'] = filtro;
			 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			 
	
			storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
			storeControlAsistencia.baseParams['rdirecto'] = rdirecto;
			storeControlAsistencia.baseParams['rextendido'] =rextendido;
			storeControlAsistencia.load();
			filterInicial.setValue(-1);
			filterInicial.setRawValue('SIN FILTRO GRUPO');
		}
	
		
		

       
		