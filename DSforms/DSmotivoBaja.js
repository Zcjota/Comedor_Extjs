
  	var winMotivoBaja;
	
		var opcion;
		
		///////////////////////////////////////
		var txtFechaBaja_r = new Ext.form.DateField(
			{
				name: 'txtFechaBaja_r',
				hideLabel: true, 
				maxLength :10,
				width:100,
				x: 130,		
				y : 15,	
				value: new Date().format('d/m/Y'),
				format : 'd/m/Y',
				allowBlank: false,
				style : {textTransform: "uppercase"},			
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
							cbomotivo_r.focus(true, 300);							
						}
					}
				}				
		});
		var store_motivo_r = new Ext.data.SimpleStore(
			{
				fields: ['codigop', 'nombrep'],
				data : [					
							['1', 'RETIRO VOLUNTARIO DEL TRABAJADOR'],			
							['2', 'VENCIMIENTO DEL CONTRATO'],
							['3', 'CONCLUSION DE OBRA'],
							['4', 'PERJUICIO MATERIAL CAUSADO CON  INTENCION EN LOS INSTRUMENTOS DE TRABAJO'],
							['5', 'REVELACION DE SECRETOS INDUSTRIALES'],
							['6', 'OMISIONES O IMPRUDENCIAS QUE AFECTEN A LA SEGURIDAD O HIGIENE INDUSTRIAL'],
							['7', 'INASISTENCIA INJUSTIFICADA DE MAS DE 6 DIAS CONTINUOS'],
							['8', 'INCUMPLIMIENTO TOTAL O PARCIAL DEL CONVENIO'],
							['9', 'ROBO O HURTO POR EL TRABAJADOR'],
							['10', 'RETIRO FORZOSO']
					],   
				autoLoad: false 		
		});	
	
			var cbomotivo_r= new Ext.form.ComboBox(
			{  
				y : 45,
				x: 130,	 				
				width : 450,
				store: store_motivo_r, 
				mode: 'local',
				//autocomplete : true,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'MOTIVO...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cbomotivo_r',
				//selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
								'select': function(cmb,record,index){
								
								
								}	 
				}		
			});
		var txtMotivoBaja = new Ext.form.TextArea({
			name: 'txtMotivoBaja',
			hideLabel: true,	
			maxLength : 200,
			width: 320,
			x: 130,
			y: 75,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						btnAceptarAp1.focus(true, 300);	
					}
				}
			}
		});	
		
		// Labels
		var lblFechaBaja = new Ext.form.Label({
			text: 'FECHA BAJA:',
			x: 10,
			y: 20,
			height: 20,
			cls: 'namelabel'
		});
		
		var lbltipo_retiro = new Ext.form.Label({
			text: 'TIPO DE RETIRO :',
			x: 10,
			y: 50,
			height: 20,
			cls: 'namelabel'
		});
		var lblMotivo = new Ext.form.Label({
			text: 'GLOSA :',
			x: 10,
			y: 80,
			height: 20,
			cls: 'namelabel'
		});
		
		// botones

		var btnAceptarAp1 = new Ext.Button({
		    id: 'btnAceptarApS',
			x: 140,
			y: 150,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				frmMotivoBaja.validarAcceso();
			} 
		});		
		
		var btnLimpiarApp1 = new Ext.Button({
		    id: 'btnLimpiarApE1',
			x: 230,
			y: 150,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = frmMotivoBaja.getForm();
				frm.reset();
				frm.clearInvalid();
				winMotivoBaja.hide();
			} 
		});		
		
		var codigo_personal=0;
		var frmMotivoBaja = new Ext.FormPanel({ 
			frame:true, 		
			layout: 'absolute',
			items:[  lblFechaBaja,lbltipo_retiro, lblMotivo,
					txtFechaBaja_r,cbomotivo_r, txtMotivoBaja
					],
					validarAcceso: function()
					{	
						frmMotivoBaja.getForm().submit(
							{	url: '../servicesAjax/DSdesactivarPersonalAJAX.php', 
									params: {codigo: codigo_personal},
									method: 'POST',
									waitTitle: 'Conectando',
									waitMsg: 'Enviando Datos...',
									success: function(form, action)
									{
										
										var frm = frmMotivoBaja.getForm();
										frm.reset();
										frm.clearInvalid();
										winMotivoBaja.hide();	
										Ext.dsdata.storedatospersonal.load({params:{start:0,limit:250}});		
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

		
        function MotivoBaja(codigo){
				
			if (!winMotivoBaja) {
				winMotivoBaja = new Ext.Window({
					layout: 'fit',
					width: 630,
					height:230,		
					title: 'MOTIVO',			
					resizable: false,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,	
					modal: true,							
					items: [frmMotivoBaja],
					buttonAlign:'center',
					buttons:[btnAceptarAp1, btnLimpiarApp1],
					listeners: {				
						show: function(){
						
							txtFechaBaja_r.focus(true, 300);
						}
					}
				});
			}
			
			var fechaActual1= new Date();
			
			txtFechaBaja_r.setValue(fechaActual1);
			cbomotivo_r.setValue('');
			txtMotivoBaja.setValue('');
			codigo_personal=codigo;
			
			winMotivoBaja.show();
		}
		
		