/*!
 * DS- TPMV
 * Copyright(c) 2012
 */

	
  var winControlAsistenciaTrabajador;
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
		
		
		var storePersona= new Ext.data.JsonStore(
		{   
			 proxy: new Ext.data.HttpProxy({
					url:'../servicesAjax/DSListaPersonalComedorGRAJAX.php'
					,timeout: 1000000
					,method: 'POST'
			}),
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
		
			
		
		storeControlAsistenciaTrabajador = new Ext.data.JsonStore({   
			 proxy: new Ext.data.HttpProxy({
					url: '../servicesAjax/DStraerControlComedorPersonal.php'
					,timeout: 1000000
					,method: 'POST'
			}),
			root: 'data',   
			totalProperty: 'total',  		
			fields: [<?php
			include("../servicesAjax/utilitario.php");
			include_once("../lib/conex.php");
			
			$conex = ConectarConBD(); // Inicializa la conexión correctamente
			if (!$conex) {
				die("Error al conectar con la base de datos");
			}
					// include("../servicesAjax/utilitario.php"); 	
					echo DevuelveCamposIndividual($conex); 
				?>],
			listeners: { 		       
					load: function(thisStore, record, ids) 
					{  		
						
						Ext.Msg.hide();											
					}
			}
			
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
			<?php  echo DevuelveColumnasIndividual($conex);	?>
			]  
			});
	function formato(value, metadata, record, rowIndex, colIndex, store) { 
			
				metadata.attr =  'style="font-size:9px;"';   
			
			
			 return value; 
		}	
		
    
	var GridControlAsistencia = new Ext.grid.EditorGridPanel({  
			id: 'gridAsistencia1',
			region:'center',
			height : 500,
			
			store: storeControlAsistenciaTrabajador,
							
			cm: Columnas1,
			columnLines: true,
			single: true,
			sm: sm,
			listeners:
			{		
				'cellclick' : function(grid, rowIndex, cellIndex, e){
					
				}
			},
			border: true,   
			enableColLock:false,
			stripeRows: false,
			view: new Ext.ux.grid.LockingGridView(),
			viewConfig:{
				
			},
		
			 
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
		
		
		var fechaini = new Ext.form.DateField({
		name: 'fecha1',
		hideLabel: true, 
		maxLength : 10,
		width: 91,
			
		format : 'd/m/Y',
		id: 'startdtVAK',
			vtype: 'daterange',
			endDateField: 'enddtVAK', // id of the end date field
		//allowBlank: true,		
		enableKeyEvents: true,
		selectOnFocus: true,
		
		});		
		var fechafin = new Ext.form.DateField({
		name: 'fecha2',
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
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					storeControlAsistenciaTrabajador.load();
					
		
				} else {
					storeControlAsistenciaTrabajador.clearFilter();
				}	
				fecha=fechaini.getValue().format('Y-m-d');
				fechaf=fechafin.getValue().format('Y-m-d');
				
			}
		});	
				
		var frmControlAsistencia = new Ext.FormPanel({ 
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
			text: 'Del  : ',
			height: 20,
			cls: 'x-label'
		});		
		var lblFechaFin	= new Ext.form.Label({
			text: 'Hasta  : ',
			height: 20,
			cls: 'x-label'
		});	
	function ExportaraExcel()
	{
		
		location = "../servicesAjax/DSExcelControlComedorPersonal.php?fecha="+fecha+'&fechaf='+fechaf+'&codPersona='+storePersona.getAt(indicePer).get('codtrabajador');  

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
								text: 'Descargar',
								icon: '../img/excel.png',
								handler: function confirm() 
								{					
									ExportaraExcel(); 
								}
							}
							
						]
			}
			
			
											
			]
	});		
		
		function IngresarControlAsistencia()
		{	
			
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
				
			}
			
			fechai="01/"+mes+"/"+year;
			
			fechaini.setValue(fechai);
			
			fecha=year+"-"+mes+"-01";
	
			fechafin.setValue(fechaActual);
			fechaf=fechaActual.format('Y-m-d');
					
		}
	
	
		

       
		