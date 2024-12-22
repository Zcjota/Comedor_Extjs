
	Date.prototype.toString = function () {
    return this.getDate() + "/" + (this.getMonth() + 1) + "/" + this.getFullYear();
	};
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
  	var winLicencia;
	
		var opcion;
		var storePersonaL= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaPersonalInformeGRAJAX.php',   
			root: 'data',  
			totalProperty: 'total',		
			fields: ['codigo', 'nombre','nombreP','app','apm','codtrabajador','cargo','unidad','subcentro','centro'],
				
		});		
		 storePersonaL.load();

		var cboPer = new Ext.form.ComboBox(
		{   		
			x: 100,
			y: 15,		
			width : 250,
			store: storePersonaL, 
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
			cls:"name1",
			listeners: {
						'select': function(cmb,record,index)
								{                    
									 g=storePersonaL.getAt(index).get('codtrabajador');
									storeCronoLicencia.load({params:{nuevo : 1,grupo:g}});	
								}
							    
			}		
		});		
		
		var storeLicencia = new Ext.data.SimpleStore(
		{
			fields: ['codigop', 'nombrep'],
			data : [					
									
						//['1', 'VACACION'],
						//['2', 'BAJA MEDICA'],
						//['4', 'OTRAS LICENCIA'],
						['5', 'ENFERMEDAD COMUN'],
						['6', 'BAJA PRE-NATAL'],
						['7', 'BAJA POST-NATAL'],
						['8', 'HOSPITALIZACIÓN'],
						['9', 'INTERVENCION QUIRURJICA'],
						['10', 'RIESGO PROFESIONAL'],
						['11', 'COVID-19']
						//['3', 'DESCANSO']	
				],   
			autoLoad: false 		
		});
		

		var cboTipoLicencias = new Ext.form.ComboBox(
		{   		
			x: 100,
			y: 45,	
			width : 250,
			store: storeLicencia, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Licencia...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbLice',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name1",
			listeners: {
						'select': function(cmb,record,index)
								{                        
									
								}
							    
			}		
		});
		var txtFechaDe = new Ext.form.DateField(
		{
			name: 'fechaap',
			id: 'startdtp',
			vtype: 'daterange',
			endDateField: 'enddtp', // id of the end date field
			hideLabel: true, 
			maxLength :10,
			width:100,
			allowBlank: false,
			x: 100,		
			y : 75,	
			value: new Date().format('d/m/Y'),
			format : 'd/m/Y',
			
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						txtMotivoAp.focus(true, 300);							
					}
				}
			}				
		});
		function validar()
		{
			hoy=new Date();
			fechacontresdiasmas=hoy.getTime()+(30*24*60*60*1000);
			// Si la queremos en formato fecha
			fechacontresdiasmasformatada= new Date(fechacontresdiasmas);
			return fechacontresdiasmasformatada;
		}
		var txtFechaHasta = new Ext.form.DateField(
		{
			name: 'fechahasta',
			id: 'enddtp',
			vtype: 'daterange',
			startDateField: 'startdtp', // id of the start date field
			hideLabel: true, 
			maxLength :10,
			width:100,
			allowBlank: false,
			x: 100,		
			y : 105,	
			value: new Date().format('d/m/Y'),
			maxValue: validar(),
			format : 'd/m/Y',
			
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						txtMotivoAp.focus(true, 300);							
					}
				}
			}				
		});

					
		// Labels
		var lblPersonal = new Ext.form.Label({
			text: 'Personal :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'x-label'
		});
		
		var lblTipoLicencia = new Ext.form.Label({
			text: 'Tipo Licencia :',
			x: 10,
			y: 50,
			height: 20,
			cls: 'x-label'
		});
		var lblfecha = new Ext.form.Label({
			text: 'De :',
			x: 10,
			y: 80,
			height: 20,
			cls: 'x-label'
		});
		var lblfechaH = new Ext.form.Label({
			text: 'Hasta :',
			x: 10,
			y: 110,
			height: 20,
			cls: 'x-label'
		});
			
		// botones

		var btnAcept = new Ext.Button({
		    id: 'btnAceptarApp',
			x: 100,
			y: 150,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
			frmMotivoLicencia.guardarDatos();
				
			} 
		});		
		
		var btnLimpiarAp = new Ext.Button({
		    id: 'btnLimpiarAp',
			x: 210,
			y: 150,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmMotivoLicencia.getForm();
				frm.reset();
				frm.clearInvalid();
				winLicencia.hide();
			} 
		});		
		
		
		storeCronoLicencia = new Ext.data.JsonStore({   
		url: '../servicesAjax/DSListaCronogramaPersonalGRAJAX.php',   
		root: 'data',   
		totalProperty: 'total',
		fields: ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'mes', 'anio', 'meslit','persona','nro'],
		listeners: { 
			load: function(thisStore, record, ids) {
					var mes = record[0].data.meslit;
					var anio = record[0].data.anio;
					LlenarEtiquetas1(mes, anio);
					if(record[0].data.persona!=0)
					{
					cboPer.setValue(record[0].data.persona);
					
					 g=record[0].data.nro;}
					// alert(record[0].data.persona);
				}
		}
		});  		
		
		
		var ColumnasC = new Ext.grid.ColumnModel(  
		[{  
			header: 'Lun',  
			dataIndex: 'lunes',  
			width: 40, 
			renderer: formato1,
			sortable: true		
		},{  
			header: 'Mar',  
			dataIndex: 'martes',  
			width: 40,
			renderer: formato1,
			sortable: true
		 },{  
			header: 'Mie',  
			dataIndex: 'miercoles',  
			width: 40,
			renderer: formato1,
			sortable: true
		},{  
			header: 'Jue',  
			dataIndex: 'jueves',    
			width: 40,
			renderer: formato1,
			sortable: true			
		},{  
			header: 'Vie',  
			dataIndex: 'viernes',  
			width: 40,
			renderer: formato1,
			sortable: true			
		},{  
			header: 'Sab',  
			dataIndex: 'sabado',  
			width: 40,
			renderer: formato1,
			sortable: true			
		},{  
			header: 'Dom',  
			dataIndex: 'domingo',  
			width: 40,
			renderer: formato1,
			sortable: true
		}
		]  
        );
		function buscar_color(value)
		{
				var x = value.length;
				
				var y=0;
				if(x>0)
				{
		
						if(value.charAt(x-1)==" ")
						{
					
							y=1;
						}
						
				}
					
					
				return y;
		}
		function formato1(value, metadata, record, rowIndex, colIndex, store) {		
			metadata.attr = 'style="white-space:normal"';	
			if (value != ''){
				metadata.attr = 'style="white-space:normal; background-color: #81BEF7"';	
			}else
				metadata.attr = 'style="white-space:normal; background-color: SILVER"';
			if(value == ' ')
			{
				metadata.attr = 'style="white-space:normal; background-color: white"';
			}
			 var f=buscar_color(value);
			 
			 if(f==1 && value !=" ")
			 {
					metadata.attr = 'style="white-space:normal; background-color: #66FF66"';
			 }
			return '<b>'+value+'</b> </br> </br> </br> </br>';
		}
		function buscar(value)
		{
				var x = value.length;
				
				var y=0;

						if(value.charAt(0)=="1" || value.charAt(0)=="2" || value.charAt(0)=="3" || value.charAt(0)=="4" || value.charAt(0)=="5" || value.charAt(0)=="6" || value.charAt(0)=="7" || value.charAt(0)=="8" || value.charAt(0)=="9")
						{
						
							y=1;
						}
					
						
				
				return y;
		}
		var gridcrono = new Ext.grid.EditorGridPanel({  
			id: 'gridcrE',
			x: 40,
			y: 230,
			width: 300,
			height : 180,
			store: storeCronoLicencia, 
			region:'center',
			cm: ColumnasC,			
			enableColLock:false, 
			selModel: new Ext.grid.RowSelectionModel({singleSelect:false}),
			border: true, 
			view: new Ext.ux.grid.BufferView({
				rowHeight: 20,
			}),
			listeners:
			{
				render:function()
				{
					storeCronoLicencia.load({params:{nuevo : 1,grupo:""}});					
				},
				'celldblclick' :function()
				{
	
				},
				'cellclick' : function(grid, rowIndex, cellIndex, e){
					var store = grid.getStore().getAt(rowIndex);
					var columnName = grid.getColumnModel().getDataIndex(cellIndex);
					var cellValue = store.get(columnName);
					mes = storeCronoLicencia.getAt(0).get('mes');
					anio = storeCronoLicencia.getAt(0).get('anio');
					var k=buscar(cellValue);
					if(k==1)
					{
						if(g=="")
						{g=0;}
						abrirServicios(cellValue, mes, anio,g);}
				}

			},
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
            })			
		});
		
		var lblMes = new Ext.form.Label({
			text: 'Noviembre',
			x: 10,
			y: 0,
			height: 30,
			cls: 'x-label'
		});
		
		var lblEspacio = new Ext.form.Label({
			text: '-',
			x: 10,
			y: 0,
			height: 30,
			cls: 'x-label'
		});
		
		var lblAnio = new Ext.form.Label({
			text: '2011',
			x: 10,
			y: 0,
			height: 30,
			cls: 'x-label'
		});
		
		// //********Funciones
		
		function LlenarEtiquetas1(mes, anio)
		{
			lblMes.setText(mes);
			lblAnio.setText(anio);
		}

		var PAmenu1 = new Ext.Panel(
		{
			align: 'center',
			x: 0,
			y: 190,
			height: 29,   
			//title: 'holaaaa',
			tbar: [ '-','-','-','-','-','-','-','-','-','-','-','-',
					{
						text: '',
						icon: '../img/izquierda.png',
						handler: function(t)
						{
							mes = storeCronoLicencia.getAt(0).get('mes');
							anio = storeCronoLicencia.getAt(0).get('anio');							
							storeCronoLicencia.load({params:{nuevo : 3, mes: mes, anio: anio,grupo:g}});						
						}
					}, '-', lblMes, lblEspacio, lblAnio, '-',
					{
						text: '',
						icon: '../img/derecha.png',
						handler: function(t)
						{
							mes = storeCronoLicencia.getAt(0).get('mes');
							anio = storeCronoLicencia.getAt(0).get('anio');							
							storeCronoLicencia.load({params:{nuevo : 2, mes: mes, anio: anio,grupo:g}});						
						}
					},'-','-','-','-','-','-','-','-','-','-','-'
				]
		});	
		
		
		
		
		var frmMotivoLicencia = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			width: 400,
			height:430,	
			items:[ lblPersonal, lblTipoLicencia,lblfecha,lblfechaH,  cboPer,cboTipoLicencias,
			        txtFechaDe,txtFechaHasta,gridcrono,PAmenu1,
					btnAcept, btnLimpiarAp],
			guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSGuardarLicencias.php',						
					//	params :{},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
								var frm = frmMotivoLicencia.getForm();
								frm.reset();
								frm.clearInvalid();
								winLicencia.hide();
								reload();
								// ActualizarJustificacionFalta();
												// storeControlAsistencia.baseParams['fechai'] = fechaini.getValue().format('Y-m-d');
												// Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										 
												 // window.setTimeout(function()
												 // {
												   // Ext.Msg.hide();							  
															   // /*********************/
														 // storeControlAsistencia.load();
															// // storeUnidad.load({params:{cbSubCentro: cboSubCentro.getValue()}});
														
					   
															   // /********************/
												 // },4000);
								storeCronoLicencia.load({params:{nuevo : 1,grupo:g}});	
						},
						failure: function(form, action){
							if (action.failureType == 'server') {
								var data = Ext.util.JSON.decode(action.response.responseText);
								Ext.Msg.alert('No se pudo conectar', data.errors.reason, function(){
									txtDescripcion.focus(true, 100);
								});
							}
							else {
								Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
							}					
						}
					});
				}
			}
		});	

		
	
        function MotivoAprobacionL(codi){	
			//alert("cdccc");
			if (!winLicencia) {
				winLicencia = new Ext.Window({
					layout: 'form',
					width: 400,
					height:430,		
					title: 'LICENCIAS',			
					resizable: false,
					closeAction: 'hide',
					closable: false,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmMotivoLicencia],
					listeners: {				
						show: function(){

						}
					}
				});
			}
			//var fechaActual = new Date(); cboGrupo,cboTipoLicencias
			//alert("SSSSSS");
			txtFechaDe.setValue("");
			txtFechaHasta.setValue("");
			//alert(codi);
			if(codi==0)
			{
				cboPer.setValue("");
				cboTipoLicencias.setValue("");
				storeCronoLicencia.load({params:{nuevo : 1,grupo:""}});
				winLicencia.show();
			}
			else
			{
				//alert("nnkjk");
				cboPer.setValue("");
				cboTipoLicencias.setValue("");
				storeCronoLicencia.load({params:{nuevo : 1,grupo:codi}});
				winLicencia.show();
			
			}
		
		
			
		}
		
		