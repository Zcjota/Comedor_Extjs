/*!
 * DS- TPMV
 * Copyright(c) 2012
 */
  	var winMotivoAprobacion;
	
		var opcion;
		var ban=0;
		var valo=0;
		var fechaAprobar;
		var minjustificados;
		///////////////////////////////////////
		var storeTipoJustificacion1= new Ext.data.JsonStore(
			{   
				url:'../servicesAjax/DSListaTipoJustificacionCBAjax.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep']			
			});		
		storeTipoJustificacion1.load();	
			
			var cboTipoJustificacion1 = new Ext.form.ComboBox(
			{   			
				width : 320,
				x: 130,
				y: 15,	
				store: storeTipoJustificacion1, 
				mode: 'local',
				//autocomplete : true,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'Tipo Justificación...',   
				//triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cbtipo_justificacion1',
				//selectOnFocus: true,
				forceSelection:true,
				cls:"name1",
				listeners: {
					'select': function(cmb,record,index){
							
					}		  
				}		
			});	
			/////////////////////////////////
		var txtFechaAprobacion = new Ext.form.DateField(
		{
			name: 'fechaappro',
			hideLabel: true, 
			maxLength :10,
			width:100,
			readOnly:true,
			x: 130,		
			y : 15,	
			value: new Date().format('d/m/Y'),
			format : 'd/m/Y',
			//allowBlank: true,
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			hidden:true,
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						txtMotivoAp.focus(true, 300);							
					}
				}
			}				
		});
		var txtminutosjustificados = new Ext.form.NumberField({
			allowDecimals: false,
			allowNegative: false,
			name: 'minJustificados',
			hideLabel: true,		
            maxLength : 3,	
			align: 'right',
			width: 80,
			 x: 135,		
			y : 15,			
			//allowBlank: true,
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			hidden:true,
			listeners: {
				
			}
		});
		var txtMotivoAp = new Ext.form.TextArea({
			name: 'motivo1',
			hideLabel: true,	
			maxLength : 200,
			width: 320,
			x: 130,
			y: 45,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						btnAceptarAp1.focus(true, 300);	
					}
				}
			}
		});	
		var txtMotivo2 = new Ext.form.TextArea({
			name: 'motivo2',
			hideLabel: true,	
			maxLength : 200,
			width: 320,
			x: 130,
			y: 120,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						btnAceptarAp1.focus(true, 300);	
					}
				}
			}
		});	
			var txtMotivo3 = new Ext.form.TextArea({
			name: 'motivo3',
			hideLabel: true,	
			maxLength : 200,
			width: 320,
			x: 130,
			y: 195,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name1",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						btnAceptarAp1.focus(true, 300);	
					}
				}
			}
		});	
					
		// Labels
		var lblFechaAnulacion = new Ext.form.Label({
			text: 'FECHA :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'namelabel'
		});
		
		var lblMotivo = new Ext.form.Label({
			text: 'RETRASOS Y FALTAS :',
			x: 10,
			y: 70,
			height: 20,
			cls: 'namelabel'
		});
		var lblMotivo2 = new Ext.form.Label({
			text: 'HORAS EXTRAS Y RN :',
			x: 10,
			y: 140,
			height: 20,
			cls: 'namelabel'
		});
		var lblMotivo3 = new Ext.form.Label({
			text: 'APROBADOR :',
			x: 10,
			y: 210,
			height: 20,
			cls: 'namelabel'
		});
		var lblMinutosJustificados = new Ext.form.Label({
			text: 'MIN JUSTIFICADOS :',
			x: 10,
			y: 15,
			height: 20,
			cls: 'namelabel',
			hidden:true,
		});	
		var lbltipojustificacion = new Ext.form.Label({
			text: 'JUSTIFICACION :',
			x: 10,
			y: 15,
			height: 20,
			cls: 'namelabel',
		});	
		// botones

		var btnAceptarAp1 = new Ext.Button({
		    id: 'btnAceptarApS',
			x: 140,
			y: 290,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmMotivoAprobacion.validarAcceso();
			} 
		});		
		
		var btnLimpiarApp1 = new Ext.Button({
		    id: 'btnLimpiarApE1',
			x: 230,
			y: 290,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmMotivoAprobacion.getForm();
				frm.reset();
				frm.clearInvalid();
				winMotivoAprobacion.hide();
			} 
		});		
		
		var frmMotivoAprobacion = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[  lblMinutosJustificados,lblMotivo, lblMotivo2, lblMotivo3,lbltipojustificacion,cboTipoJustificacion1,
			        txtminutosjustificados,txtFechaAprobacion, txtMotivoAp,txtMotivo2,txtMotivo3,
					btnAceptarAp1, btnLimpiarApp1],
					validarAcceso: function()
					{	
						frmMotivoAprobacion.getForm().submit(
							{	url: '../servicesAjax/DSpasarTipoJustificacion.php', 
									params: {tipo_justificacion: cboTipoJustificacion1.getValue()},
									method: 'POST',
									waitTitle: 'Conectando',
									waitMsg: 'Enviando Datos...',
									success: function(form, action)
									{
										PasarMotivoAprobacion();
										var frm = frmMotivoAprobacion.getForm();
										frm.reset();
										frm.clearInvalid();
										winMotivoAprobacion.hide();			
									},					
									failure: function(form, action)
									{if (action.failureType == 'server') 
										{	var data = Ext.util.JSON.decode(action.response.responseText);
											Ext.Msg.alert('BUGS', data.errors.reason, function()
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
		});	

		function PasarMotivoAprobacion()
		{ 
			fechaap = txtFechaAprobacion.getValue().format('Y/m/d');
			motivoap	= txtMotivoAp.getValue();
			motivog2	= txtMotivo2.getValue();
			motivog3	= txtMotivo3.getValue();
			minutosj	= txtminutosjustificados.getValue();
			LlenarMotivoAprobacion(fechaap, motivoap,motivog2,motivog3,ban,valo,fechaAprobar,minutosj);
		}
		function TraerGloza(codigo,fechaG,minjustificados)
		{
			 //registros = [];
			// storeDetalleAprobador.loadData(registros);
			//alert("HA");
			storeDatosGrid = new Ext.data.JsonStore(
			{
				url:'../servicesAjax/DSTraerJ.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep','nombrep1','nombrep2','minutos','idjustificacion'],			
				listeners: { 		       
					load: function(thisStore, record, ids) 
					{  					
						for(i = 0; i<this.getCount();i++){
							//registro = new Array(8);
							//dimension = registros.length;"nombrep1" 	=> $row['MOTIVO_HE'],
				//"nombrep2" 	=> $row['MOTIVO_APROBADOR'],
							//registro[0] = record[i].data.codigop;
							txtMotivoAp.setValue(record[i].data.nombrep);
							txtMotivo2.setValue(record[i].data.nombrep1);
							txtMotivo3.setValue(record[i].data.nombrep2);
							txtminutosjustificados.setValue(record[i].data.minutos);
							cboTipoJustificacion1.setValue(record[i].data.idjustificacion)
							//alert(record[i].data.nombrep);
							//registros[dimension] = registro;	
						}											
						//storeDetalleAprobador.loadData(registros);												
					}
				}
			});
			storeDatosGrid.load({params:{codigo:codigo,fecha:fechaG}});
			
			
		}
        function MotivoAprobacion(codigo,fecha,aux,bandera,valor,min1,min2){
				
			if (!winMotivoAprobacion) {
				winMotivoAprobacion = new Ext.Window({
					layout: 'fit',
					width: 500,
					height:370,		
					title: 'GLOSA JUSTIFICACION',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,								
					items: [frmMotivoAprobacion],
					listeners: {				
						show: function(){
						
							
							txtFechaAprobacion.focus(true, 300);
						}
					}
				});
			}
			if(aux==1)
							{
						//	alert(aux);
								btnAceptarAp1.setDisabled(true);
							}
							else
							{
								btnAceptarAp1.setDisabled(false);
							}
			ban=bandera;
			valo=valor;
			var fechaActual1= new Date();
			
			txtFechaAprobacion.setValue(fechaActual1);
			minjustificados=parseInt(min1);
			// if(min2!="F" && min2!="SM")
			// {
			// minjustificados=parseInt(min1)+parseInt(min2);
			
			// }
			txtminutosjustificados.setValue(minjustificados);
			txtMotivoAp.setValue("");
			txtMotivo2.setValue("");
			txtMotivo3.setValue("");
			cboTipoJustificacion1.setValue("");
			fechaAprobar=fecha;
			TraerGloza(codigo,fecha,minjustificados);
			winMotivoAprobacion.show();
		}
		
		