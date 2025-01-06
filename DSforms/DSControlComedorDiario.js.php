/*!
 * DS- TPMV
 * Copyright(c) 2012
 */
  var winControlComedor;

	
	var rowIndex=-1;
	var fm=Ext.form;
		
	
		var encode = false;
		var local = true;
		var filters = new Ext.ux.grid.GridFilters({
        // encode and local configuration options defined previously for easier reuse
        encode: encode, // json encode the filter query
        local: local,   // defaults to false (remote filtering)
        filters: [ 
			<?php
include("../servicesAjax/utilitario.php");
include_once("../lib/conex.php");

$conex = ConectarConBD(); // Inicializa la conexión correctamente
if (!$conex) {
    die("Error al conectar con la base de datos");
}

echo DevuelveListaCampos($conex); // Pasa la conexión como argumento
?>

                 ]
    }); 
	var storeHorarioComedor= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaHorarioComedorCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeHorarioComedor.load();
		
		var cboHorario_Comedor = new Ext.form.ComboBox(
		{   			
			width : 130,
			store: storeHorarioComedor, 
			mode: 'local',
			
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Horario...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cboHorario_Comedor',
			selectOnFocus: true,
			forceSelection:true,
			value:'0',
			listeners: {
				'select': function(cmb,record,index){
						
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
						rowIndex = row;							
                    },
					
                }
            });
	
		storeControlComedor = new Ext.data.JsonStore({  
			 proxy: new Ext.data.HttpProxy({
					url: '../servicesAjax/DSListaTraerMarcacionesComedor.php'
					,timeout: 1000000
					,method: 'POST'
			}),
			root: 'data',   
			
			totalProperty: 'total',  		
			fields: [<?php
					
					echo DevuelveCampos($conex); 
				?>],
			listeners: { 
						load: function(thisStore, record, ids) {
								Ext.Msg.hide();											
							}
					}
			});  	
			
			var Columnas1 = new Ext.ux.grid.LockingColumnModel({ 
			defaults: {
            sortable: true // columns are not sortable by default           
			},
			columns: [	
				<?php  echo DevuelveColumnas($conex);	?>]  
			});
	function formato(value, metadata, record, rowIndex, colIndex, store) { 
			
				metadata.attr =  'style="font-size:9px;"';   
			
			
			 return value; 
		}
	var GridControlComedor = new Ext.grid.EditorGridPanel({  
		id: 'gridAsistenciaComedor',
		region:'center',
		loadMask: true,
		height : 500,
		store: storeControlComedor,
		cm: Columnas1,
		columnLines: true,
		sm: sm,
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
		view: new Ext.ux.grid.LockingGridView(),	
	   viewConfig:{
				getRowClass : function (row, index) {
					
				 },
							 
			},
			stateful: true,
			plugins: [filters],
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
				frmControlComedor.getForm().reset;					
				winControlComedor.hide();
			} 
		});	
		var lblHorario_l= new Ext.form.Label({
			text:'',
			x: 10,
			y: 170,
			height: 20,
			html: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Horario:</a>',
			cls: 'namelabel',
		});	
		var fechaini = new Ext.form.DateField({
		name: 'fecha1',
		hideLabel: true, 
		maxLength : 10,
		width: 91,
			
		format : 'd/m/Y',
		//allowBlank: true,		
		enableKeyEvents: true,
		selectOnFocus: true,
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
													storeControlComedor.baseParams['horario'] =	cboHorario_Comedor.getValue();
													storeControlComedor.baseParams['fechai'] = fechiniv;
													 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
													
													storeControlComedor.reload({params:o});
													
										
												} else {
													storeControlComedor.clearFilter();
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
				
				var fechiniv;
				if (fechaini.getValue() > 0)
					{fechiniv = fechaini.getValue().format('Y-m-d');}
				else
					{fechiniv = '';}
				
				
				if( fechiniv.length > 0 )
				{  
					var o = {start : 0, limit:100};					
					storeControlComedor.baseParams['horario'] =	cboHorario_Comedor.getValue();
					storeControlComedor.baseParams['fechai'] = fechiniv;
					 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
					
					storeControlComedor.reload({params:o});
					
		
				} else {
					storeControlComedor.clearFilter();
				}	
				fecha=fechaini.getValue().format('Y-m-d');
				
			}
		});	
				
		var frmControlComedor = new Ext.FormPanel({ 
			frame:true, 
			height: 400,
			items:[ GridControlComedor],
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
							storeControlComedor.reload();
							
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
		var registrosGridexcel;
		function Registro() { 
			var store = Ext.getCmp("gridAsistenciaComedor").getStore();
		
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
									location = "../servicesAjax/DSExcelControlAsistenciaComedor.php?fecha="+fecha;  
									
			 Ext.Msg.hide();
							}
					}
			}); 
			storeexcel.baseParams['reg'] =registrosGridexcel;
			storeexcel.load();	
					

		}
		var PAmenu = new Ext.Panel(
		{
			region: 'north',
			id: 'PAcabecera1',
			height: 29,   
			tbar: [
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
					
					
						lblHorario_l,'-',cboHorario_Comedor,'-',fechaini, '-', bfilter														
				]
		});		
			
		function IngresarControlAsistencia()
		{	
			var viewport1 = new Ext.Viewport(
			{
				layout: 'border',
							
				items: [PAmenu,GridControlComedor]
			}); 
			
			var fechaActual = new Date()
			fechaini.setValue(fechaActual);
			fecha=fechaActual.format('Y-m-d');
			
			
			 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
			 
			storeControlComedor.baseParams['horario'] =	cboHorario_Comedor.getValue();
			storeControlComedor.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
			
			storeControlComedor.load();		
		}	