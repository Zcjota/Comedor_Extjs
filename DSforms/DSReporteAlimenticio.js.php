/*!
 * DS- CACC
 * Copyright(c) 2018
 */

  var winReporteAlimenticio;
	var rowIndex=-1;
	var fecha;
	var fm=Ext.form;
	Ext.apply(Ext.form.VTypes, {
			daterange: function (val, field) {
				var date = field.parseDate(val);

				if (!date) {
					return;
				}
				if (field.startDateField && (!this.dateRangeMax || (date.getTime() !== this.dateRangeMax.getTime()))) {
					var start = Ext.getCmp(field.startDateField);
					start.setMaxValue(date);
					start.validate();
					this.dateRangeMax = date;
				}
				else if (field.endDateField && (!this.dateRangeMin || (date.getTime() !== this.dateRangeMin.getTime()))) {
					var end = Ext.getCmp(field.endDateField);
					end.setMinValue(date);
					end.validate();
					this.dateRangeMin = date;
				}
				return true;
			}
		});	
	
	storeControlMes = new Ext.data.JsonStore({   
		proxy: new Ext.data.HttpProxy({
			url: '../servicesAjax/DStraerResumenBeneficio.php'
			,timeout: 1000000
			,method: 'POST'
		}),
		root: 'data',   
		totalProperty: 'total',  	 
		fields: [<?php
					include("../servicesAjax/utilitario_comedor.php"); 	
					echo DevuelveCamposResumenComedor(); 
				?>],
					listeners: { 
					load: function(thisStore, record, ids) {	
					    	Ext.Msg.hide();	
						}
				}
		});  	
			
			var Columnass = new Ext.grid.ColumnModel( { 
			defaults: {
            sortable: true // columns are not sortable by default           
			},
			columns: [	
			<?php
					
					echo DevuelveColumnasResumenComedor(); 
				?>
			]  
			});
	function formato(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}
	
		
	var gridCC = new Ext.grid.EditorGridPanel({  
			id: 'griComedorBeneficio',
			region:'center',
		     height : 500,
			 loadMask: true,
			store: storeControlMes,	
			cm: Columnass,
			single: true,
			sm: new Ext.grid.RowSelectionModel(
			{
                singleSelect: true,
                listeners: 
				{
					rowselect: function(sm, row, rec) 
					{                        
						rowIndex = row;	
						
                    }
                }
            }),
			listeners:
			{
				'cellclick' : function(grid, rowIndex, cellIndex, e){
					var store = grid.getStore().getAt(rowIndex);
					var columnName = grid.getColumnModel().getDataIndex(cellIndex);
					var cellValue = store.get(columnName);
				
				}
			},
			border: true,   
			enableColLock:false,
			stripeRows: false,
			
			 
		});			
	
		
	
		var fechaini = new Ext.form.DateField({
		name: 'fecha1',
		hideLabel: true, 
		maxLength : 10,
		width: 91,
		id: 'startdtVAK',
		vtype: 'daterange',
		endDateField: 'enddtVAK', // id of the end date field	
		format : 'd/m/Y',
		//allowBlank: true,		
		enableKeyEvents: true,
		selectOnFocus: true,
		
		});		
		var fechafin = new Ext.form.DateField({
		name: 'fechafin',
		hideLabel: true, 
		maxLength : 10,
		width: 91,
		id: 'enddtVAK',
		vtype: 'daterange',
		startDateField: 'startdtVAK', // id of the start date field		
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
				
				
				if( fechiniv.length > 0 )
				{  
					var o = {start : 0, limit:100};		
					
					storeControlMes.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
					storeControlMes.baseParams['fechaf'] = fechafin.getValue().format('Y-m-d');
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					storeControlMes.load();
					
					
		
				} else {
					storeControlMes.clearFilter();
				}	
				fecha=fechaini.getValue().format('Y-m-d');
				
			}
		});	
	var btnExportarPDF = new Ext.Button({
		id: 'btnExportarPDF',
		text: 'Descargar',
		icon: '../img/pdf_button.png',
		minWidth: 80,
		handler: function () {
		   vfechaini=fechaini.getValue().format('Y-m-d');
			vfechafin=fechafin.getValue().format('Y-m-d');
		   var pagina = "../servicesAjax/DSReporteAlimenticioPDF.php?fechaf="+vfechafin+"&fechai="+vfechaini;
		   var opciones = "toolbar=yes, location=no, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=yes, width=1000, height=800, top=0, left=0";
		   window.open(pagina,"",opciones);
		   
		}
	});
		var registrosGridexcel;
		function Registro() { 
			var store = Ext.getCmp("griComedorBeneficio").getStore();
		
			var datosGrid1 = []; 
				var i=0;			
			store.each(function(rec){                                                       
				datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
				i++;
   			});    	
			
			registrosGridexcel = Ext.encode(datosGrid1);
		}
		function ExportaraExcel()
		{
			vfechaini=fechaini.getValue().format('d-m-Y');
			vfechafin=fechafin.getValue().format('d-m-Y');
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
									location = "../servicesAjax/DSExcelControlBeneficioConsolidado.php?fechaini="+vfechaini+"&fechafin="+vfechafin;  	
									Ext.Msg.hide();
							}
					}
			}); 
			storeexcel.baseParams['reg'] =registrosGridexcel;
			storeexcel.load();	
		}
		var lblFechaIni	= new Ext.form.Label({
			text: 'Del : ',
			height: 20,
			cls: 'x-label'
		});	
		var lblFechaFin	= new Ext.form.Label({
			text: 'Hasta  : ',
			height: 20,
			cls: 'x-label'
		});				
		var PAmenu = new Ext.Panel({
		region: 'north',
		id: 'PAmenuPrA',
		height: 29,   
		tbar: ['->',
			{
				xtype: 'buttongroup',
				columns: 7,
				 defaults: { scale: 'small'},
				items: [
						lblFechaIni,
						{
							xtype: 'tbseparator'
						},
						fechaini,
						{
							xtype: 'tbseparator'
						},
						lblFechaFin,
						{
							xtype: 'tbseparator'
						},fechafin
					]
			},
			{
				xtype: 'buttongroup',
				columns: 3,
				 defaults: { scale: 'small'},
				items: [
						 bfilter,
							{
								text: 'Descargar',
								icon: '../img/excel.png',
								handler: function confirm() 
								{		
									Registro();
									ExportaraExcel(); 
								}
							}
							<!-- ,btnExportarPDF -->
							
						]
			},
											
			]
	});	
		
		function ResumenComedor()
		{	
			var viewport1 = new Ext.Viewport(
			{
				layout: 'border',
							
				items: [PAmenu,gridCC]
			}); 
			
			 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 
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
		
			}
			fechai="01/"+mes+"/"+year;
			fechaini.setValue(fechai);
			fecha=year+"-"+mes+"-01";
			fechafin.setValue(fechaActual);
			fechaf=fechaActual.format('Y-m-d');
			
			storeControlMes.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
			storeControlMes.baseParams['fechaf'] = fechafin.getValue().format('Y-m-d');
			storeControlMes.load();
						
		}
	
		
		

       
		