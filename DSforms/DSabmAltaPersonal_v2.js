		var windatosPersonal;
		Ext.form.NumberField.override ({
			/*
			 * @cfg {Boolean} true forces the field to show following zeroes. e.g.: 20.00
			 */
			forceDecimalPrecision : false
			
		   ,fixPrecision : function(value){
			   var nan = isNaN(value);
			   if(!this.allowDecimals || this.decimalPrecision == -1 || nan || !value){
				  return nan ? '' : value;
			   }
			   value = parseFloat(value).toFixed(this.decimalPrecision);
			   if(this.forceDecimalPrecision)return value
			   return parseFloat(value);
		   }
		   ,setValue : function(v){
			   if(!Ext.isEmpty(v)){
				   if(typeof v != 'number'){
					   if(this.forceDecimalPrecision){
						   v = parseFloat(String(v).replace(this.decimalSeparator, ".")).toFixed(this.decimalPrecision);
					   } else {
						   v = parseFloat(String(v).replace(this.decimalSeparator, "."));
					   }
				   }
				   v = isNaN(v) ? '' : String(v).replace(".", this.decimalSeparator);
			   }
			   return Ext.form.NumberField.superclass.setValue.call(this, v);
		   }
	   });
		var codigo;
		var opcion;
		var ind;
		var aux=0;
		var aux1=0;
		var bandera=0;
		var txtNombre = new Ext.form.TextField({
				name: 'nombre',
				maxLength : 30,
				width: 90,
				x: 140,
				y: 15,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtSegNombre.focus(true, 300);
						}
					}
				}
		});	
		var txtSegNombre = new Ext.form.TextField({
				name: 'Segnombre',
				maxLength : 30,
				width: 90,
				x: 380,
				y: 15,
				
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtTerNombre.focus(true, 300);
						}
					}
				}
		});	
		var txtTerNombre = new Ext.form.TextField({
			name: 'txtTerNombre',
			maxLength : 30,
			width: 90,
			x: 610,
			y: 15,
			
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						txtapp.focus(true, 300);
					}
				}
			}
	});
		var txtapp = new Ext.form.TextField({
				name: 'app',
				maxLength : 50,
				width: 90,
				x: 140,
				y: 45,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtapm.focus(true, 300);
						}
					}
				}
		});	
		var active=0;
    var chkactive = [
		  {
			xtype  : 'checkbox',
			name: 'active',
			id: 'active',
			boxLabel: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Activo</a>',
			inputValue : '1',
			x:730,
			y:0,
			checked: true,
			handler: function() { 				
				if (this.getValue() == true)
				{
					active=1;
					
				}
				else
				{
					active=0;
				
				} 
			} 		  
		  }
	    ]
		var txtapm = new Ext.form.TextField({
				name: 'apm',
				maxLength : 50,
				width: 90,
				x: 380,
				y: 45,
				allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtapcasada.focus(true, 300);
						}
					}
				}
		});	
		var txtapcasada = new Ext.form.TextField({
			name: 'txtapcasada',
			maxLength : 50,
			width: 90,
			x: 610,
			y: 45,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						txtci.focus(true, 300);
					}
				}
			}
	});	
	var storeTipoDocumento = new Ext.data.SimpleStore(
		{
			fields: ['codigoex', 'desex'],
			data : [					
						['CI', 'CI'],			
						['PASAPORTE', 'PASAPORTE'],
						['CE', 'CE']
				],   
			autoLoad: false 		
		});
		var cboTipoDocumento = new Ext.form.ComboBox({   	
			x: 140,
			y: 75,			
			width : 90,
			store: storeTipoDocumento,
					
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Tipo Doc...',   
			triggerAction: 'all',   		
			displayField:'desex',   
			//typeAhead: true,
			valueField: 'desex',
			hiddenName : 'cboTipoDocumento',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
						keypress: function(t,e){
						if(e.getKey()==13){
							txtci.focus(true, 300);
						}
					}
					
				}						
			}		
		);
		// var txtci= new Ext.form.TextField({
				// name: 'ci',
				// maxLength : 50,
				// width: 170,
				// x: 140,
				// y: 75,
				// allowBlank: false,
				// style : {textTransform: "uppercase"},
				// blankText: 'Campo requerido',
				// enableKeyEvents: true,
				// selectOnFocus: true,
				// cls:"name",
				// listeners: {
					// keypress: function(t,e){
						// if(e.getKey()==13){
							// cboExtension.focus(true, 300);
						// }
					// }
				// }
		// });	
		var txtci = new Ext.form.NumberField({
				allowDecimals: true,
				allowBlank: false,
				allowNegative: false,
				name: 'ci',
				hideLabel: true,		
				maxLength : 20,	
				align: 'right',
				width: 90,
				x: 380,
				y: 75,
				value : 0,
				style : {textTransform: "uppercase"},			
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
							
						}
					}
				}
			});	
		var storeExtension = new Ext.data.SimpleStore(
		{
			fields: ['codigoex', 'desex'],
			data : [					
						['1', 'BE'],			
						['2', 'CB'],
						['3', 'CH'],			
						['4', 'LP'],
						['5', 'OR'],			
						['6', 'PA'],
						['7', 'PO'],			
						['8', 'SC'],
						['9', 'TJ'],
						['10', 'EXT'],
						['11', 'PE']
							
				],   
			autoLoad: false 		
		});
		var cboExtension = new Ext.form.ComboBox({   	
			x: 610,
			y: 75,			
			width : 90,
			store: storeExtension,
					
			mode: 'local',
			//autocomplete : true,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Extension...',   
			triggerAction: 'all',   		
			displayField:'desex',   
			//typeAhead: true,
			valueField: 'desex',
			hiddenName : 'extension',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
						keypress: function(t,e){
						if(e.getKey()==13){
							txtFVencDoc.focus(true, 300);
						}
					}
					
				}						
			}		
		);
		var txtFVencDoc = new Ext.form.DateField({
			name: 'txtFVencDoc',
			hideLabel: true, 
			maxLength : 10,
			width: 75,
			y : 75,
			x: 820,		
			format : 'd/m/Y',
			//allowBlank: true,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
							
						txtcomplemento.focus(true, 300);
					}
				}
			}				
		});
		var txtcomplemento = new Ext.form.TextField({
			name: 'txtcomplemento',
			maxLength : 50,
			width: 60,
			y : 75,
			x: 1020,	
			allowBlank: true,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						txtnacionalidad.focus(true, 300);
					}
				}
			}
	});	
		var storeNacionalidad= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaNacionalidadCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeNacionalidad.load();

		var cboNacionalidad = new Ext.form.ComboBox(
		{   	
			hidden:true,
			x: 140,
			y: 105,		
			width : 120,
			store: storeNacionalidad, 
			mode: 'local',
			//autocomplete : true,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Nacionalidad...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'nombrep',
			hiddenName : 'cbnacionalidad',
		//	selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
						if(e.getKey()==13){
							cboGenero.focus(true, 300);
						}
					}
						  
			}		
		});	
		var txtnacionalidad= new Ext.form.TextField({
				name: 'txtnacionalidad',
				maxLength : 200,
				x: 140,
				y: 105,		
				width : 90,	
				style : {textTransform: "uppercase"},
				emptyText:'NACIONALIDAD...',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							cboGenero.focus(true, 300);
						}
					}
				}
		});	
		var storeGenero = new Ext.data.SimpleStore(
		{
			fields: ['codigoge', 'desge'],
			data : [					
						['1', 'MASCULINO'],			
						['2', 'FEMENINO'],	
							
				],   
			autoLoad: false 		
		});
		var cboGenero = new Ext.form.ComboBox({   	
			x: 380,
			y: 105,			
			width : 90,
			store: storeGenero,
					
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Genero...',   
			triggerAction: 'all',   		
			displayField:'desge',   
			//typeAhead: true,
			valueField: 'desge',
			hiddenName : 'genero',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
						keypress: function(t,e){
						if(e.getKey()==13){
							//cboPais.focus(true, 300);
						}
					}
					
					}						
			}		
		);
		var storeNI = new Ext.data.SimpleStore(
		{
			fields: ['cod', 'des'],
			data : [					
						['', 'NINGUNA'],			
						['Primaria', 'PRIMARIA'],			
						['Secundaria', 'SECUNDARIA'],	
						['Egresado bachiller', 'EGRESADO BACHILLER'],	
						['Técnico medio', 'TECNICO MEDIO'],	
						['Técnico superior', 'TECNICO SUPERIOR'],	
						['Cursando estudio universitario', 'CURSANDO ESTUDIOS UNIVERSITARIOS'],	
						['Egresado universitario', 'EGRESADO UNIVERSITARIO'],	
						['Titulado universitario', 'TITULADO UNIVERSITARIO'],	
						['Postgrado y/o maestria', 'POST GRADO Y/O MAESTRIA'],	
							
				],   
			autoLoad: false 		
		});
		
		var cboNivelInstruccion = new Ext.form.ComboBox({   	
			x: 610,
			y: 105,			
			width : 140,
			store: storeNI,					
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Nivel Inst...',   
			triggerAction: 'all',   		
			displayField:'des',   
			//typeAhead: true,
			valueField: 'cod',
			hiddenName : 'nivelinstruccion',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
						keypress: function(t,e){
						if(e.getKey()==13){
							//cboPais.focus(true, 300);
						}
					}
					
					}						
			}		
		);
		var txtprofesion = new Ext.form.TextField({
			name: 'txtprofesion',
			maxLength : 50,
			x: 880,
			y: 105,			
			width : 200,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
	});	
		
			var txtpais_nacimiento= new Ext.form.TextField({
				name: 'txtpais_nacimiento',
				maxLength : 200,
				width: 120,
				x: 140,
				y: 135,		
				style : {textTransform: "uppercase"},
				emptyText:'PAIS...',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
		var storePais= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaPaisCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storePais.load();

		var cboPais = new Ext.form.ComboBox(
		{   	
			hidden:true,
			x: 140,
			y: 140,		
			width : 120,
			store: storePais, 
			mode: 'local',
			//autocomplete : true,
		//	allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Pais...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
		//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbpais',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
						  'select': function(cmb,record,index){
							cboCiudad.setValue('');
							cboProvincia.setValue('');
							storeCiudad.load({params:{cbpais: cboPais.getValue()}});	
							
							cboCiudad.focus(true, 300);
							 cboCiudad.enable(false);
							
							}		    
			}		
		});	
		
	var storeCiudad= new Ext.data.JsonStore(
		{   
		url:'../servicesAjax/DSListaCiudadCBAjax.php',
		root: 'data',
		totalProperty: 'total',
		fields: ['codigoci', 'nombreci']
		
		});		
	
	var txtciudad_nacimiento= new Ext.form.TextField({
				name: 'txtciudad_nacimiento',
				maxLength : 200,
				width: 120,
				x: 300,
				y: 135,			
				style : {textTransform: "uppercase"},
				emptyText:'DEPARTAMENTO...',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
	var cboCiudad = new Ext.form.ComboBox(
	{   	
		hidden:true,
		x: 300,
		y: 140,		
		width : 120,
		store: storeCiudad, 
		mode: 'local',
		disabled: true,		
		//autocomplete : true,
		//allowBlank: false,
		style : {textTransform: "uppercase"},
		emptyText:'Ciudad...',   
		triggerAction: 'all',   		
		displayField:'nombreci',   
		//typeAhead: true,
		valueField: 'codigoci',
		hiddenName : 'ciudades',
		//selectOnFocus: true,
			forceSelection:true,
		cls:"name",
		listeners: {
			 'select': function(cmb,record,index){
							cboProvincia.setValue('');
							storeProvincia.load({params:{cbciudad: cboCiudad.getValue()}});	
							
							cboProvincia.focus(true, 300);
							 cboProvincia.enable(false);
							
							}	
				          
		}		
		});	
	var storeProvincia= new Ext.data.JsonStore(
		{   
		url:'../servicesAjax/DSListaProvinciaCBAjax.php',
		root: 'data',
		totalProperty: 'total',
		fields: ['codigopr', 'nombrepr']
		
		});		
	
	var txtprovincia_nacimiento= new Ext.form.TextField({
				name: 'txtprovincia_nacimiento',
				maxLength : 200,
				width: 200,
				x: 470,
				y: 135,			
				style : {textTransform: "uppercase"},
				emptyText:'PROVINCIA...',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
	var cboProvincia = new Ext.form.ComboBox(
	{   
		hidden:true,
		x: 470,
		y: 140,		
		width : 170,
		store: storeProvincia, 
		mode: 'local',
		disabled: true,		
		//autocomplete : true,
		//allowBlank: false,
		style : {textTransform: "uppercase"},
		emptyText:'Provincia...',   
		triggerAction: 'all',   		
		displayField:'nombrepr',   
		//typeAhead: true,
		valueField: 'codigopr',
		hiddenName : 'provincia',
		//selectOnFocus: true,
	   forceSelection:true,
		cls:"name",
		listeners: {
			
				'select': function(cmb,record,index){
							aux1=1;
							
							},	
			
				          
		}		
		});	
		
		var txtFechaNacimiento = new Ext.form.DateField({
			name: 'fechaNacimiento',
			hideLabel: true, 
			maxLength : 10,
			width: 91,
			y : 165,
			x: 140,		
			format : 'd/m/Y',
			//allowBlank: true,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
							
						cboTipoSangre.focus(true, 300);
					}
				}
			}				
		});
			var txtCorreoPersonal = new Ext.form.TextField({
				name: 'correo_personal',
				maxLength : 150,
				width: 200,
				x: 610,
				y: 285,
			
				vtype:'email',
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							cboEstadoCivil.focus(true, 300);
						}
					}
				}
		});	
		
		var storeTipoSangre = new Ext.data.SimpleStore(
		{
			fields: ['codigoge', 'desge'],
			data : [					
						['1', 'O RH+'],			
						['2', 'O RH-'],	
						['3', 'A RH+'],			
						['4', 'A RH-'],
						['5', 'B RH+'],			
						['6', 'B RH-'],	
						['7', 'AB RH+'],			
						['8', 'AB RH-'],						
				],   
			autoLoad: false 		
		});
		var cboTipoSangre = new Ext.form.ComboBox({   	
			x: 380,
			y: 165,			
			width : 90,
			store: storeTipoSangre,
					
			mode: 'local',
			//autocomplete : true,
		
			style : {textTransform: "uppercase"},
			emptyText:'Tipo Sangre...',   
			triggerAction: 'all',   		
			displayField:'desge',   
			//typeAhead: true,
			valueField: 'desge',
			hiddenName : 'tiposangre',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
						
				}						
			}		
		);
		var storeEstadoCivil = new Ext.data.SimpleStore(
			{
				fields: ['codigoge', 'desge'],
				data : [					
							['1', 'CASADO'],			
							['2', 'SOLTERO'],	
							['3', 'VIUDO'],			
							['4', 'CONCUBINO'],	
							['5', 'DIVORCIADO'],	
							['6', 'SEPARADO'],
					],   
				autoLoad: false 		
			});
			var cboEstadoCivil = new Ext.form.ComboBox({   	
				x: 610,
				y: 165,			
				width : 100,
				store: storeEstadoCivil,
						
				mode: 'local',
				//autocomplete : true,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'Estado Civil...',   
				triggerAction: 'all',   		
				displayField:'desge',   
				//typeAhead: true,
				valueField: 'desge',
				hiddenName : 'estado_civil',
				//selectOnFocus: true,
				forceSelection:true,
				cls:"name",
				listeners: {
						
							}						
				}		
			);
		var txtpais_domicilio= new Ext.form.TextField({
				name: 'txtpais_domicilio',
				maxLength : 200,
				width: 120,
				x: 140,
				y: 195,		
				style : {textTransform: "uppercase"},
				emptyText:'PAIS...',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
		var cboPaisDomicilio = new Ext.form.ComboBox(
		{   		
			hidden:true,
			x: 140,
			y: 195,		
			width : 120,
			store: storePais, 
			mode: 'local',
			//autocomplete : true,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Pais...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbpaisdomicilio',
			//selectOnFocus: true,
			forceSelection:true,
			cls:"name",
			listeners: {
						  'select': function(cmb,record,index){
							cboCiudadDomicilio.setValue('');
							cboProvinciaDomicilio.setValue('');
							storeCiudad.load({params:{cbpais: cboPaisDomicilio.getValue()}});	
							
							cboCiudadDomicilio.focus(true, 300);
							 cboCiudadDomicilio.enable(false);
							
							}		    
			}		
		});	
	var txtciudad_domicilio= new Ext.form.TextField({
				name: 'txtciudad_domicilio',
				maxLength : 200,
				x: 300,
				y: 195,		
				width : 120,	
				style : {textTransform: "uppercase"},
				emptyText:'DEPARTAMENTO...',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
	var cboCiudadDomicilio = new Ext.form.ComboBox(
	{   	
		hidden:true,
		x: 300,
		y: 195,		
		width : 120,
		store: storeCiudad, 
		mode: 'local',
		disabled: true,		
		//autocomplete : true,
		//allowBlank: false,
		style : {textTransform: "uppercase"},
		emptyText:'Ciudad...',   
		triggerAction: 'all',   		
		displayField:'nombreci',   
		//typeAhead: true,
		valueField: 'codigoci',
		hiddenName : 'cbciudadesdomicilio',
		//selectOnFocus: true,
		forceSelection:true,
		cls:"name",
		listeners: {
			 'select': function(cmb,record,index){
							cboProvinciaDomicilio.setValue('');
							storeProvincia.load({params:{cbciudad: cboCiudadDomicilio.getValue()}});	
							
							cboProvinciaDomicilio.focus(true, 300);
							 cboProvinciaDomicilio.enable(false);
							
							}	
				          
		}		
		});	
	var txtprovincia_domicilio= new Ext.form.TextField({
				name: 'txtprovincia_domicilio',
				maxLength : 200,
				x: 470,
				y: 195,		
				width : 200,	
				style : {textTransform: "uppercase"},
				emptyText:'PROVINCIA...',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
	var cboProvinciaDomicilio = new Ext.form.ComboBox(
	{   	
		hidden:true,
		x: 470,
		y: 195,		
		width : 170,
		store: storeProvincia, 
		mode: 'local',
		disabled: true,		
		//autocomplete : true,
		//allowBlank: false,
		style : {textTransform: "uppercase"},
		emptyText:'Provincia...',   
		triggerAction: 'all',   		
		displayField:'nombrepr',   
		//typeAhead: true,
		valueField: 'codigopr',
		hiddenName : 'cbprovinciaDomilio',
		//selectOnFocus: true,
	    forceSelection:true,
		cls:"name",
		listeners: {
				    	 'select': function(cmb,record,index){
							aux=1;
							txtZona.focus(true, 300);
							}	      
		}		
		});
		var txtZona = new Ext.form.TextField({
				name: 'zona',
				maxLength : 200,
				width: 250,
				y : 225,
				x: 140,		
				
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtDireccionDomicilio.focus(true, 300);
						}
					}
				}
		});	
		var txtDireccionDomicilio = new Ext.form.TextField({
				name: 'direccionDomicilio',
				maxLength : 200,
				width: 350,
				y : 225,
				x: 510,		
				
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtTelefono1.focus(true, 300);
						}
					}
				}
		});	
		var txtTelefono1 = new Ext.form.TextField({
				name: 'telefonofijo',
				maxLength : 50,
				width: 150,
				y : 255,
				x: 140,		
				
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtTelefono2.focus(true, 300);
						}
					}
				}
		});
		var txtTelefono2 = new Ext.form.TextField({
				name: 'telefonofijo2',
				maxLength : 50,
				width: 150,
				y : 255,
				x: 470,		
			
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtcelular1.focus(true, 300);
						}
					}
				}
		});
		var txtcelular1 = new Ext.form.TextField({
				name: 'celular1',
				maxLength : 50,
				width: 90,
				y : 285,
				x: 140,		
				
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtcelular2.focus(true, 300);
						}
					}
				}
		});
		var txtcelular2 = new Ext.form.TextField({
				name: 'celular2',
				maxLength : 50,
				width: 90,
				y : 285,
				x: 380,		
			
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							txtCorreoPersonal.focus(true, 300);
						}
					}
				}
		});
	
	var txtnro_lic = new Ext.form.TextField({
			name: 'txtnro_lic',
			maxLength : 30,
			width: 90,
			x: 140,
			y: 315,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						txttipo_lic.focus(true, 300);
					}
				}
			}
	});	
	var storetipo_licencia = new Ext.data.SimpleStore(
		{
			fields: ['codigop', 'nombrep'],
			data : [					
						['M', 'MOTOCICLISTA (M)'],			
						['P', 'PARTICULAR (P)'],
						['A', 'PROFESIONAL (A)'],	
						['B', 'PROFESIONAL (B)'],
						['C', 'PROFESIONAL (C)'],
						['T', 'MOTORISTA (T)'],
							
				],   
			autoLoad: false 		
	});	
	var txttipo_lic= new Ext.form.ComboBox(
		{  
			width: 115,
			x: 380,
			y: 315,
			store: storetipo_licencia, 
			mode: 'local',
			//autocomplete : true,
		//	allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'TIPO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'txttipo_lic',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
						   'select': function(cmb,record,index){
						  
							
							}	 
			}		
			});	
	/*var txttipo_lic = new Ext.form.TextField({
			name: 'txttipo_lic',
			maxLength : 30,
			width: 90,
			x: 380,
			y: 315,
			
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
	});	*/
	var txtfecha_venc_lic = new Ext.form.DateField({
		name: 'txtfecha_venc_lic',
		hideLabel: true, 
		maxLength : 10,
		width: 90,
		x: 610,
		y: 315,		
		format : 'd/m/Y',
		//allowBlank: true,		
		enableKeyEvents: true,
		selectOnFocus: true,
		cls:"name",
		listeners: {
			keypress: function(t,e){				
				if(e.getKey()==13){
						
					txtcontacto_emergencia.focus(true, 300);
				}
			}
		}				
	});
	
		var txtcontacto_emergencia = new Ext.form.TextField({
			name: 'txtcontacto_emergencia',
			maxLength : 150,
			width: 200,
			x: 140,
			y: 345,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						txttel_contacto.focus(true, 300);
					}
				}
			}
		});	
		var txttel_contacto = new Ext.form.TextField({
			name: 'txttel_contacto',
			maxLength : 30,
			width: 90,
			x: 580,
			y: 345,
			
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						txtdir_contacto.focus(true, 300);
					}
				}
			}
		});	
		var txtdir_contacto = new Ext.form.TextField({
		name: 'txtdir_contacto',
		maxLength : 200,
		width: 200,
		x: 140,
		y: 375,

		style : {textTransform: "uppercase"},
		blankText: 'Campo requerido',
		enableKeyEvents: true,
		selectOnFocus: true,
		cls:"name",
		listeners: {
			keypress: function(t,e){
				if(e.getKey()==13){
					
				}
			}
		}
		});
		//////////////////////////
		///////////////foto perfil
		foto="";
		var registros = new Array(); 
		function ActualizarGrid(foto)
		{				
			dimension = registros.length;
			var registro = new Array(5);
			
		
				
					registro[0] = 1;
					
					registro[1] = 1;
					registro[2] = foto; 
					
			
					registros[dimension] = registro;		

					storeFoto.loadData(registros);
				
				
				
			
			
		} 
		var randonfoto=1;
		var fichero_perfil = new Ext.form.FileUploadField(
		{  
            x : 890,
			y : 135,           
            name: 'fichero_perfil',            
            width: 150,  
			//allowBlank: false,
			cls: 'name',
            buttonCfg: {  
                text: '',  
                iconCls: 'upload-icon'  
            },
			listeners:
			{
				'fileselected': function(fb, v)
				{
					dire = v;
					randonfoto=randonfoto+1;
					PAmenu.guardarFoto();
					
				}
			}		
		});
		var storeFoto= new Ext.data.ArrayStore({// Ext.create('Ext.data.ArrayStore',{  
			fields: [ 'codigo',
			   {name: 'codp'},
			   {name: 'foto'}
			],  
			id: 0
		});
		
		var Columnas_Foto = new Ext.grid.ColumnModel(  
		[
			{  
				header: 'codigo',  
				dataIndex: 'codigo',  									
				hidden: true
			},{  
				header: 'Codigo',  
				dataIndex: 'codp',  									
				width : 100,
				hidden: true
			}
			,{  
				header: '',  
				dataIndex: 'foto',  
				width: 137,
				align: 'center',
				sortable: true,
				renderer: function(value, cell){  
					if(value!='')
					{
						str ="<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../foto/"+value+"' WIDTH='105' HEIGHT='105'/> </div> ";
						return str;
					}
					else
					{
						str ="<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../foto/perfil.png' WIDTH='105' HEIGHT='105'/> </div> ";
						return str;
					}       
				}
			}
			]
        );
		var gridfoto = new Ext.grid.EditorGridPanel({  
			id: 'gridfoto',			
			height: 130,
			width : 140,
			x: 900,
			y: 165,	
			store: storeFoto,	
						
			cm: Columnas_Foto, 			
			border: false,   
			enableColLock:false,
			stripeRows: true,				
			deferRowRender: false,
			
			destroy : function () {
				if (this.store) {
					this.store.destroyStore();
				}
				this.callParent();
			},
		});
	    ////////////////////////////////////////////////////////
		// Labels
		
		var lblNombre = new Ext.form.Label({
			text: 'PRIMER NOMBRE :',
			x: 10,
			y: 20,
			height: 20,
			cls: 'namelabel'
		});	
		var lblNombre2 = new Ext.form.Label({
			text: 'SEGUNDO NOMBRE :',
			x: 260,
			y: 20,
			height: 20,
			cls: 'namelabel'
		});	
		var lblNombre3 = new Ext.form.Label({
			text: 'TERCER NOMBRE :',
			x: 510,
			y: 20,
			height: 20,
			cls: 'namelabel'
		});	
		var lblapp = new Ext.form.Label({
			text: 'AP. PATERNO :',
			x: 10,
			y: 45,
			height: 20,
			cls: 'namelabel'
		});	
		var lblapm = new Ext.form.Label({
			text: 'AP. MATERNO :',
			x: 260,
			y: 45,
			height: 20,
			cls: 'namelabel'
		});	
		var lblapcasada = new Ext.form.Label({
			text: 'AP. CASADA :',
			x: 510,
			y: 45,
			height: 20,
			cls: 'namelabel'
		});	
		var lbltipoDocumento = new Ext.form.Label({
			text: 'TIPO DOCUMENTO :',
			x: 10,
			y: 75,
			height: 20,
			cls: 'namelabel'
		});
		var lblci = new Ext.form.Label({
			text: 'NRO DOCUMENTO :',
			x: 260,
			y: 75,
			height: 20,
			cls: 'namelabel'
		});
		var lblextension = new Ext.form.Label({
			text: 'EXTENSION:',
			x: 510,
			y: 75,
			height: 20,
			cls: 'namelabel'
		});
		var lblfvencimientodoc = new Ext.form.Label({
			text: '',
			x: 740,
			y: 75,
			height: 20,
			cls: 'namelabel',
			html:'FECHA VENC.<br> DOC:'
		});
		var lblcomplemento = new Ext.form.Label({
			text: 'COMPLEMENTO:',
			x: 935,
			y: 75,
			height: 20,
			cls: 'namelabel'
		});
		var lblNacionalidad = new Ext.form.Label({
			text: 'NACIONALIDAD:',
			x: 10,
			y: 105,
			height: 20,
			cls: 'namelabel'
		});
		var lblgenero = new Ext.form.Label({
			text: 'GENERO:',
			x: 260,
			y: 105,
			height: 20,
			cls: 'namelabel'
		});
		var lblnivelinstruccion= new Ext.form.Label({
			text: '',
			x: 510,
			y: 105,
			height: 20,
			cls: 'namelabel',
			html:'NIVEL <br>INSTRUCCION:'
		});
		var lblprofesion_oficio = new Ext.form.Label({
			text: 'PROFESION U OFIC.:',
			x: 770,
			y: 105,
			height: 20,
			cls: 'namelabel'
		});
		var lblPais = new Ext.form.Label({
			text: 'LUGAR NACIMIENTO',
			x: 10,
			y: 140,
			height: 20,
			cls: 'namelabel'
		});
		
		var lblTipoSangre = new Ext.form.Label({
			text: 'TIPO DE SANGRE :',
			x: 260,
			y: 165,
			height: 20,
			cls: 'namelabel'
		});
		var lblEstadoCivil = new Ext.form.Label({
			text: 'ESTADO CIVIL :',
			x: 510,
			y: 165,
			height: 20,
			cls: 'namelabel'
		});	
		var lblFecha = new Ext.form.Label({
			text: 'FECHA NACIMIENTO :',
			x: 10,
			y: 165,
			height: 20,
			cls: 'namelabel'
		});
		var lbllugardomicilio = new Ext.form.Label({
			text: 'LUGAR DE DOMICILIO:',
			x: 10,
			y: 195,
			height: 20,
			cls: 'namelabel'
		});
		var lblZona = new Ext.form.Label({
			text: 'ZONA DOMICILIO:',
			x: 10,
			y: 225,
			height: 20,
			cls: 'namelabel'
		});
		var lbldirecciondomicilio = new Ext.form.Label({
			text: '',
			x: 420,
			y: 225,
			height: 20,
			cls: 'namelabel',
			html:'DIRECCION <br>DOMICILIO:'
		});
		var lblTelefono1 = new Ext.form.Label({
			text: 'TELEFONO PARTICULAR:',
			x: 10,
			y: 255,
			height: 20,
			cls: 'namelabel'
		});
		var lblTelefono2 = new Ext.form.Label({
			text: 'OTRO TELEFONO :',
			x: 350,
			y: 255,
			height: 20,
			cls: 'namelabel'
		});
		var lblCelular1 = new Ext.form.Label({
			text: 'CELULAR PARTICULAR:',
			x: 10,
			y: 285,
			height: 20,
			cls: 'namelabel'
		});
		var lblCelular2 = new Ext.form.Label({
			text: 'RHEGYSTER:',
			x: 260,
			y: 285,
			height: 20,
			cls: 'namelabel'
		});
		var lblcorreo_personal = new Ext.form.Label({
			text: 'CORREO PERSONAL:',
			x: 510,
			y: 285,
			height: 20,
			cls: 'namelabel'
		});

		var lblNroLicencia = new Ext.form.Label({
			text: 'NRO LICENCIA :',
			x: 10,
			y: 315,
			height: 20,
			cls: 'namelabel'
		});	
		var lbltipoLicencia = new Ext.form.Label({
			text: 'TIPO LICENCIA :',
			x: 260,
			y: 315,
			height: 20,
			cls: 'namelabel'
		});	
		var lblfecha_venc_lic = new Ext.form.Label({
			text: 'FECHA VENC. LIC. :',
			x: 510,
			y: 315,
			height: 20,
			cls: 'namelabel'
		});	

		var lblNombre_contacto = new Ext.form.Label({
			text: 'CONTACTO EMERGENCIA :',
			x: 10,
			y: 345,
			height: 20,
			cls: 'namelabel'
		});	
		var lbltel_contacto = new Ext.form.Label({
			text: 'TELF. CONTACTO :',
			x: 460,
			y: 345,
			height: 20,
			cls: 'namelabel'
		});	
		var lbldir_contacto = new Ext.form.Label({
			text: 'DIR. CONTACTO :',
			x: 10,
			y: 375,
			height: 20,
			cls: 'namelabel'
		});	
		


		var lblfechaCertificado = new Ext.form.Label({
			text: 'FECHA CERTIFICADO PTJ:',
			x: 10,
			y: 345,
			height: 20,
			cls: 'namelabel'
		});
		
		var lblHorario = new Ext.form.Label({
			text: 'HORARIO:',
			x: 10,
			y: 345,
			height: 20,
			cls: 'namelabel'
		});
		
		// botones

		var btnAceptarPersonal = new Ext.Button({
		    id: 'btnAceptarPersonal',
			x: 100,
			y: 380,
			text: 'Guardar',
			icon: '../img/save.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				if(tipo_contrato==1){
					//mostrarFecha(89,txtFechaIngreso.getValue());
				}
				if(aux==1)
				{
					
				}
				else{
					if(cboProvinciaDomicilio.getValue()!="")
					cboProvinciaDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('codprovdir'));
				}
				if(aux1==1){}
				else{
					if(cboProvinciaDomicilio.getValue()!="")
							cboProvincia.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('codprov'));}
				
				var tabPanel = Ext.getCmp("main-tabs");
					 tabPanel.show();
					tabPanel.setActiveTab("t1");
					tabPanel.setActiveTab("t2");
					tabPanel.setActiveTab("t5");
					tabPanel.setActiveTab("t3");
					tabPanel.setActiveTab("t4");
					
					txtFechaFin.setDisabled(false);
					txtFechaIngreso.setDisabled(false);

					var store = Ext.getCmp("GridDependiente").getStore();
					var datosGrid1 = []; 
						var i=0;			
					store.each(function(rec){  					
							datosGrid1.push(Ext.apply({id:rec.id},rec.data)); 
								i++;
						
					});  
					registrosGrid_m = Ext.encode(datosGrid1);
					var datosGrid2 = [];  
					smR.each(function(rec){ 
						datosGrid2.push(Ext.apply({id:rec.id},rec.data));            
					});    	
 
					registrosGrid_conceptos = Ext.encode(datosGrid2);
					PAmenu.guardarDatos(registrosGrid_m,registrosGrid_conceptos);
				
			} 
		});		
		
		var btnLimpiarPersonal = new Ext.Button({
		    id: 'btnLimpiarPersonal',
			x: 190,
			y: 380,
			text: 'Cancelar',
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				var frm = PAmenu.getForm();
				frm.reset();
				frm.clearInvalid();
				windatosPersonal.hide();
			} 
		});		

		//AFILIACION
		
			
		
		
	var txtFechaIngreso = new Ext.form.DateField({
			name: 'fechaIngreso',
			hideLabel: true, 
			maxLength : 10,
			width: 91,
			x: 110,
			y: 105,
				
			format : 'd/m/Y',
			allowBlank: false,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls: 'name',
				listeners: {
						
						change: function (t,n,o) {
							if(tipo_contrato==1){
							mostrarFecha(89,txtFechaIngreso.getValue());
							}
						}
					}			
		});	
		
		
		var txtFechaIndemnizacion= new Ext.form.DateField({
			name: 'txtFechaIndemnizacion',
			hideLabel: true, 
			maxLength : 10,
			width: 150,
			x: 905,
			y: 495,				
			format : 'd/m/Y',
			allowBlank: false,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
									
					}
				}
			}				
		});
		
	
		
		var txtFechaCertificadoPTJ= new Ext.form.DateField({
			hidden:true,
			name: 'txtFechaCertificadoPTJ',
			hideLabel: true, 
			maxLength : 10,
			width: 91,
			y : 165,
			x: 140,		
			format : 'd/m/Y',
			allowBlank: true,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
									
					}
				}
			}				
		});
		
		//label
		
		var lblfechaindemnizacion = new Ext.form.Label({
			text: 'FECHA INDEMNIZACION:',
			x: 10,
			y: 140,
			height: 20,
			cls: 'namelabel'
		});
		
		var lblfechaDeCertificadoPTJ = new Ext.form.Label({
			text: 'FECHA CERTIFICADO PTJ :',
			x: 10,
			y: 170,
			height: 20,
			cls: 'namelabel'
		});
		
		
	
	//ESTRUCTURA ORGANIZACIONAL
		var txtNroTrabajador = new Ext.form.NumberField({
				allowDecimals: true,
				allowBlank: false,
				allowNegative: false,
				name: 'nro',
				hideLabel: true,		
				maxLength : 20,	
				align: 'right',
				width: 150,
				x: 110,
				y: 15,	
				value : 0,
				style : {textTransform: "uppercase"},			
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
							
						}
					}
				}
			});	
		// var txtNroTrabajador= new Ext.form.TextField({
				// name: 'nro',
				// maxLength : 50,
				// width: 80,
				// x: 140,
				// y: 15,
				// allowBlank: false,
				// style : {textTransform: "uppercase"},
				// blankText: 'Campo requerido',
				// enableKeyEvents: true,
				// selectOnFocus: true,
				// cls: 'name',
				// listeners: {
					
				// }
		// });	
		var storePlanilla = new Ext.data.SimpleStore(
		{
			fields: ['codigop', 'nombrep'],
			data : [					
						['1', 'SERVICIOS EXTERNOS'],			
						['0', 'SUELDOS Y SALARIOS'],	
							
				],   
			autoLoad: false 		
		});	
		var cboPlanilla= new Ext.form.ComboBox(
		{   
			x: 370,
			y: 15,
			width : 150,
			store: storePlanilla, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbplanilla',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
				'select': function(cmb,record,index){
					 planilla_aux=storePlanilla.getAt(index).get('codigop');
					 var data = [];
						storeConceptos.each(function(rec)
						{
						data.push(rec.data);
						}
					);
					if(planilla_aux==0)
					{
						val_aporte=1;
						val_afp=1;
						Ext.getCmp('idaguinaldo_si').setValue('1');
						Ext.getCmp('idaguinaldo2_no').setValue('2');
						Ext.getCmp('idprima_si').setValue('1');
						Ext.getCmp('idretroactivo_no').setValue('2');
						Ext.getCmp('idaportes_patronales_si').setValue('1');
						Ext.getCmp('idaplica_planilla_si').setValue('1');
						Ext.getCmp('idindemnizacion_si').setValue('1');
						Ext.getCmp('idaplica_afp_si').setValue('1');
						Ext.getCmp('idaplicaretencion_si').setDisabled(true);
						Ext.getCmp('idaplicaretencion_no').setDisabled(true);
						Ext.getCmp('idaplicaretencion_no').setValue('2');
						Ext.getCmp('idaporta_afp_si').setValue('1');
						cboTIPOAFP.setValue(1);
						
						
						var pos = 0;  
						var miArray = new Array(); 
						miArray=[];
						
						gridConceptos.getSelectionModel().selectRows(data, false);
						storeConceptos.each(function(record){
							if(record.data.id == 14 || record.data.id == 15 || record.data.id == 16 || record.data.id == 17
								|| record.data.id == 10 || record.data.id == 11 || record.data.id == 12 || record.data.id == 13 || record.data.id == 18
								|| record.data.id == 21  || record.data.id == 23 || record.data.id == 24 || record.data.id == 25){
								
								record.data.ticket=1;	
							}
							if(record.data.id == 27 || record.data.id == 28 || record.data.id == 22){
								
								record.data.ticket=0;	
							}
							
						});
						var chx = Ext.getCmp('gridConceptos'); 
						chx.getStore().commitChanges();
						chx.getView().refresh();
						var i=0;
						storeConceptos.each(function(record){

							if(parseInt(record.data.ticket) == 1){  
								miArray[pos] = i;  
								pos++;  
							}  
							
							i++;
							
							
						});
						
						gridConceptos.getSelectionModel().selectRows(miArray, true);
						
						var chx = Ext.getCmp('gridConceptos'); 
						chx.getStore().commitChanges();
						chx.getView().refresh();

						////////////////////////////
						//storeConceptos.load({params:{codigo: 0,val_aporte:val_aporte,val_afp:val_afp}});// val=1: si corresponde
						cboTipoTrabajador.setDisabled(false);
						//txtDomingosMes.setValue('0');
						txtDomingosMes.setDisabled(false);
						cboTipoEvaluacion.setDisabled(false);
					}
					if(planilla_aux==1)
					{
						val_aporte=0;
						val_afp=0;
						Ext.getCmp('idaguinaldo_no').setValue('2');
						Ext.getCmp('idaguinaldo2_no').setValue('2');
						Ext.getCmp('idprima_no').setValue('2');
						Ext.getCmp('idretroactivo_no').setValue('2');
						Ext.getCmp('idaportes_patronales_no').setValue('2');
						Ext.getCmp('idaplica_planilla_no').setValue('2');
						Ext.getCmp('idindemnizacion_no').setValue('2');
						Ext.getCmp('idaplica_afp_no').setValue('2');
						Ext.getCmp('idaplicaretencion_si').setDisabled(false);
						Ext.getCmp('idaplicaretencion_no').setDisabled(false);
						//Ext.getCmp('idaplicaretencion_si').setValue('1');
						Ext.getCmp('idaplicaretencion_no').setValue('2');

						Ext.getCmp('idaporta_afp_no').setValue('2');
						cboTIPOAFP.setValue('');
						var pos = 0;  
						var miArray = new Array(); 
						miArray=[];
						gridConceptos.getSelectionModel().selectRows(data, false);
							storeConceptos.each(function(record){
								if(record.data.id == 14 || record.data.id == 15 || record.data.id == 16 || record.data.id == 17
									|| record.data.id == 10 || record.data.id == 11 || record.data.id == 12 || record.data.id == 13 || record.data.id == 18
									|| record.data.id == 21 || record.data.id == 22 || record.data.id == 23 || record.data.id == 24 || record.data.id == 25){
									record.data.ticket=0;	
								}
								if(record.data.id == 27 || record.data.id == 28){
									
									record.data.ticket=0;	
								}
								
							});
							var i=0;
							var chx = Ext.getCmp('gridConceptos'); 
							chx.getStore().commitChanges();
							chx.getView().refresh();
							storeConceptos.each(function(record){
								if(parseInt(record.data.ticket) == 1){  
									
									miArray[pos] = i;  
									pos++;  
								} 

								i++;
								
							});
							gridConceptos.getSelectionModel().selectRows(miArray, true);
						
							var chx = Ext.getCmp('gridConceptos'); 
							chx.getStore().commitChanges();
							chx.getView().refresh();
						//storeConceptos.load({params:{codigo: 0,val_aporte:val_aporte,val_afp:val_afp}});// val=1: si corresponde
						cboTipoTrabajador.setValue(1);
						cboDominical.setValue(0);
						
									txtDomingosMes.setValue('0');
									txtDomingosMes.setDisabled(true);

								
									
									
								
						cboTipoTrabajador.setDisabled(true);
						cboTipoEvaluacion.setDisabled(true);
						//setDisabled(false);
					}	
				}	
						 	    
			}		
			});	
			var RBvAplica_retencion_imp = new Ext.form.RadioGroup({
				xtype: 'radiogroup',
				fieldLabel: 'Aplica retencion_imp',
				x: 650,
				y: 15,				
				id:'rbaplica_retencion_imp',
				items: [{
						xtype: 'radiogroup',
						width : 150,
						items: [
							{boxLabel: 'SI',id: 'idaplicaretencion_si', name: 'rb-retencion_imp', inputValue: '1',checked: true,
								listeners: {
									change: function () {
										var pos = 0;  
										var miArray = new Array();
										miArray=[];
										if (Ext.getCmp('idaplicaretencion_si').getValue() === true) {
											
											storeConceptos.each(function(record){
												if(record.data.id == 27 || record.data.id == 28){
													
													record.data.ticket=1;	
												}
												
											});
											var chx = Ext.getCmp('gridConceptos'); 
											chx.getStore().commitChanges();
											chx.getView().refresh();
											var i=0;
											storeConceptos.each(function(record){
			
												if(parseInt(record.data.ticket) == 1){  
													miArray[pos] = i;  
													pos++;  
												}  
												
												i++;
												
												
											});
											
											gridConceptos.getSelectionModel().selectRows(miArray, true);
											
											var chx = Ext.getCmp('gridConceptos'); 
											chx.getStore().commitChanges();
											chx.getView().refresh();
										}
									}
								}
							},
							{boxLabel: 'NO',  id: 'idaplicaretencion_no', name: 'rb-retencion_imp', inputValue: '2', 
								listeners: {
									change: function () {
										var pos = 0;  
										var miArray = new Array(); 
										miArray=[];
										if (Ext.getCmp('idaplicaretencion_no').getValue() === true) {
											
											gridConceptos.getSelectionModel().selectRows(miArray, false);
											storeConceptos.each(function(record){
												if(record.data.id == 27 || record.data.id == 28){
													record.data.ticket=0;	
												}
												
											});
											var i=0;
											var chx = Ext.getCmp('gridConceptos'); 
											chx.getStore().commitChanges();
											chx.getView().refresh();
											storeConceptos.each(function(record){
												if(parseInt(record.data.ticket) == 1){  
													miArray[pos] = i;  
													pos++;  
												} 
				
												i++;
												
											});
											gridConceptos.getSelectionModel().selectRows(miArray, true);
										
											var chx = Ext.getCmp('gridConceptos'); 
											chx.getStore().commitChanges();
											chx.getView().refresh();
										}
									}
								}
			
							}
						]
					}]
			});
		var storeSubcentro= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaSubCentroCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep'],
			listeners: { 		       
					load: function(thisStore, record, ids) 
					{  					
						if(bandera==1)
						{
							cboSubCentro.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cod_subcentro'));
							storecentro.load({params:{cbUnidad: cboUnidad.getValue(),cbSubCentro: cboSubCentro.getValue()}});
						}
						if(bandera==2)
						{
							cboSubCentro.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cod_subcentro'));
							storecentro.load({params:{cbUnidad: cboUnidad.getValue(),cbSubCentro: cboSubCentro.getValue()}});
						}
					}
			}
		});	
		// var storeSubcentro= new Ext.data.JsonStore(
		// {   
			// url:'../servicesAjax/DSListaSubCentroCBAjax.php',   
			// root: 'data',  
			// totalProperty: 'total',
			// fields: ['codigop', 'nombrep'],
			
		// });		
		//storeSubcentro.load();

		var cboSubCentro= new Ext.form.ComboBox(
		{   
			// x: 140,
			// y: 15,	
			x: 370,
			y: 45,		
			width : 150,
			store: storeSubcentro, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione SUBCENTRO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbsubcentro',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
				
				 'select': function(cmb,record,index){
							bandera=0;
							cboCentro.setValue('');
							storecentro.load({params:{cbUnidad: cboUnidad.getValue(),cbSubCentro: cboSubCentro.getValue()}});	
								
							cboCentro.focus(true, 300);
							 cboCentro.enable(false);
							
							}	
				  
						 
			}		
			});	
		var storeUnidad= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaUnidadCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeUnidad.load();

		var cboUnidad = new Ext.form.ComboBox(
		{   		
			x: 110,
			y: 45,	
			// x: 470,
			// y: 15,
			width : 150,
			store: storeUnidad, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione UNIDAD...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbunidad',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
					  'select': function(cmb,record,index){
					   bandera=0;
							cboSubCentro.setValue('');
							cboCentro.setValue('');
							storeSubcentro.load({params:{cbUnidad: cboUnidad.getValue()}});	
							
							cboSubCentro.focus(true, 300);
							 cboSubCentro.enable(false);
							
							}	
					
						  
			}		
			});	
		var storecentro= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaCentroCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']	,
			listeners: { 		       
					load: function(thisStore, record, ids) 
					{  					
						if(bandera==1)
						{
							 cboCentro.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('codcentro'));
					  
							cboCargo.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cargo'));
							txtNroTrabajador.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cod_trabajador'));
							// windatosPersonal.show();
							// Ext.Msg.hide();
						}
						if(bandera==2)
						{
							 cboCentro.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('codcentro'));
					  
							cboCargo.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cargo'));
							// txtNroTrabajador.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cod_trabajador'));
							// windatosPersonal.show();
							// Ext.Msg.hide();
						}
					}
			}
		});	
		// var storecentro= new Ext.data.JsonStore(
		// {   
			// url:'../servicesAjax/DSListaCentroCBAjax.php',   
			// root: 'data',  
			// totalProperty: 'total',
			// fields: ['codigop', 'nombrep']	,
			
		// });		
		//storecentro.load();

		var cboCentro= new Ext.form.ComboBox(
		{   
			x: 650,
			y: 45,			
			width : 120,
			store: storecentro, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione CENTRO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbcentro',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
						 
						 
			}		
		});	
		
		var storecargo= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaCargoCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storecargo.load();

		var cboCargo= new Ext.form.ComboBox(
		{   		
			x: 850,
			y: 45,			
			width : 245,
			store: storecargo, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione CARGO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbcargo',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
						  
			}		
			});	
		var storeTipoTrabajador= new Ext.data.JsonStore(
			{   
				url:'../servicesAjax/DSListaTipoTrabajadorCBAjax.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep']			
			});		
		storeTipoTrabajador.load();
	
		var cboTipoTrabajador= new Ext.form.ComboBox(
			{   	
				x: 110,
				y: 75,
				// x: 140,
				// y: 75,		
				width : 150,
				store: storeTipoTrabajador, 
				mode: 'local',
				//autocomplete : true,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'Seleccione TIPO TRABAJADOR...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cbtipotrabajador',
				selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
					'select': function(cmb,record,index){
						trabajdor_aux=storeTipoTrabajador.getAt(index).get('codigop');
					   if(trabajdor_aux==1)
					   {
						cboDominical.setValue(0);
						txtDomingosMes.setValue('0');
						txtDomingosMes.setDisabled(true);
						
					   }
					   if(trabajdor_aux==2)
					   {
						cboDominical.setValue(1);
						//txtDomingosMes.setValue('0');
						txtDomingosMes.setDisabled(false);
					   }	
				   }	
								
				}		
			});	
		var storeTipoEvaluacion= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaTipoEvaluacion.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeTipoEvaluacion.load();

		var cboTipoEvaluacion= new Ext.form.ComboBox(
		{   		 
			y : 225,
			x: 650,		
			width : 150,
			store: storeTipoEvaluacion, 
			mode: 'local',
			//autocomplete : true,
		//	allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'TIPO EVALUACION...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbTipoEvaluacion',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
						   'select': function(cmb,record,index){
						  
							
							}	 
			}		
			});	
		var txtFechaParaVacionesEspeciales= new Ext.form.DateField({
				name: 'txtFechaParaVacionesEspeciales',
				hideLabel: true, 
				maxLength : 10,
				width: 150,
				x: 370,
				y: 105,		
				format : 'd/m/Y',
				allowBlank: false,		
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
										
						}
					}
				}				
			});	
		var txtFechaParaBonoAntiguedad= new Ext.form.DateField({
				name: 'txtFechaParaBonoAntiguedad',
				hideLabel: true, 
				maxLength : 10,
				width: 120,
				x: 650,
				y: 105,		
				format : 'd/m/Y',
				allowBlank: false,		
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
										
						}
					}
				}				
			});
			var storemodalidad_trabajo = new Ext.data.SimpleStore(
				{
					fields: ['codigop', 'nombrep'],
					data : [					
								['1', 'PRESENCIAL'],			
								['2', 'SEMIPRESENCIAL'],
								['3', 'TELETRABAJO']	
									
						],   
					autoLoad: false 		
			});	
		
				var cboModalidadTrabajo= new Ext.form.ComboBox(
				{   
					x: 880,
					y: 75,				
					width : 150,
					store: storemodalidad_trabajo, 
					mode: 'local',
					//autocomplete : true,
				//	allowBlank: false,
					style : {textTransform: "uppercase"},
					emptyText:'MODALIDAD...',   
					triggerAction: 'all',   		
					displayField:'nombrep',   
					//typeAhead: true,
					valueField: 'codigop',
					hiddenName : 'cboModalidadTrabajo',
					//selectOnFocus: true,
					forceSelection:true,
					cls: 'name',
					listeners: {
								   'select': function(cmb,record,index){
								  
									
									}	 
					}		
					});	
			var storeclasificacion_laboral = new Ext.data.SimpleStore(
				{
					fields: ['codigop', 'nombrep'],
					data : [					
								['1', 'NO ESPECIFICADO'],			
								['2', 'OCUPACIONES DE DIRECCION EN LA ADMINISTRACION PUBLICA Y EMPRESAS'],
								['3', 'OCUPACIONES DE PROFESIONALES CIENTIFICOS E INTELECTUALES'],	
								['4', 'OCUPACIONES DE TECNICOS Y PROFESIONALES DE APOYO'],
								['5', 'EMPLEADOS DE OFICINA'],
								['6', 'TRABAJADORES DE LOS SERVICIOS Y VENDEDORES DEL COMERCIO'],
								['7', 'PRODUCTORES Y TRABAJADORES EN LA AGRICULTURA, PECUARIA, AGROPECUARIA, PESCA'],
								['8', 'TRABAJADORES DE LA INDUSTRIA EXTRACTIVA, CONSTRUCCION, INDUSTRIA MANUFACTURERA Y OTROS OFICIOS'],
								['9', 'OPERADORES DE INSTALACIONES Y MAQUINARIAS'],
								['10', 'TRABAJADORES NO CALIFICADOS'],
								['11', 'FUERZAS ARMADAS']
									
						],   
					autoLoad: false 		
			});	
		
				var cboclasificacion_laboral= new Ext.form.ComboBox(
				{  
					y : 165,
					x: 110,	 				
					width : 665,
					store: storeclasificacion_laboral, 
					mode: 'local',
					//autocomplete : true,
				//	allowBlank: false,
					style : {textTransform: "uppercase"},
					emptyText:'CLASIFICACION...',   
					triggerAction: 'all',   		
					displayField:'nombrep',   
					//typeAhead: true,
					valueField: 'codigop',
					hiddenName : 'cboclasificacion_laboral',
					//selectOnFocus: true,
					forceSelection:true,
					cls: 'name',
					listeners: {
									'select': function(cmb,record,index){
									
									
									}	 
					}		
					});	
			var storeTipoContratoModo = new Ext.data.SimpleStore(
				{
					fields: ['codigop', 'nombrep'],
					data : [					
								['1', 'VERBAL'],			
								['2', 'ESCRITO']
						],   
					autoLoad: false 		
			});	
		
				var cboTipoContrato_modo= new Ext.form.ComboBox(
				{  
					
					x: 650,
					y: 75,				
					width : 120,
					store: storeTipoContratoModo, 
					mode: 'local',
					//autocomplete : true,
				//	allowBlank: false,
					style : {textTransform: "uppercase"},
					emptyText:'TIPO CONTRATO...',   
					triggerAction: 'all',   		
					displayField:'nombrep',   
					//typeAhead: true,
					valueField: 'codigop',
					hiddenName : 'cboTipoContrato_modo',
					//selectOnFocus: true,
					forceSelection:true,
					cls: 'name',
					listeners: {
									'select': function(cmb,record,index){
									
									
									}	 
					}		
				});	
		
			var txtTelefonoFijoLaboral = new Ext.form.TextField({
					name: 'txtTelefonoFijoLaboral',
					maxLength : 30,
					width: 90,
					x: 850,
					y: 135,	
					allowBlank: true,
					style : {textTransform: "uppercase"},
					enableKeyEvents: true,
					selectOnFocus: true,
					cls:"name",
					listeners: {
						keypress: function(t,e){
							if(e.getKey()==13){
								
							}
						}
					}
			});
			var txtInterno = new Ext.form.TextField({
				name: 'txtInterno',
				maxLength : 30,
				width: 90,
				x: 1005,
				y: 135,	
				allowBlank: true,
				style : {textTransform: "uppercase"},
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
			});
			var txtdireccionLaboral = new Ext.form.TextField({
				name: 'txtdireccionLaboral',
				maxLength : 200,
				width: 150,
				x: 590,
				y: 135,	
				allowBlank: true,
				style : {textTransform: "uppercase"},
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});		
		var storeHorario= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaHorarioCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		//storeHorario.load();

		var cboHorario = new Ext.form.ComboBox(
		{   		
			x: 140,
			y: 105,		
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
						  
			}		
		});	
			
			/////////////////////////////////////////////////////////////////////////////////////
			
		var storeTipoContrato = new Ext.data.SimpleStore(
		{
			fields: ['codigop', 'nombrep'],
			data : [					
						//['1', 'INDEFINIDO'],			
						//['2', 'POR TEMPORADA'],	
								['1', 'TIEMPO INDEFINIDO'],
								['2', 'POR TEMPORADA'],
								['3', 'A PLAZO FIJO'],			
								['4', 'CONDICIONAL O EVENTUAL'],
								['5', 'POR REALIZACION DE OBRAS O SERVICIO']	
								
								
							
				],   
			autoLoad: false 		
		});
		// var storeTipoContrato= new Ext.data.JsonStore(
		// {   
			// url:'../servicesAjax/DSListaTipoTrabajadorCBAjax.php',   
			// root: 'data',  
			// totalProperty: 'total',
			// fields: ['codigop', 'nombrep']			
		// });		
		//storeTipoContrato.load();
		var txtFechaFin = new Ext.form.DateField({
			name: 'fechafin',
			hideLabel: true, 
			maxLength : 10,
			width: 91,
			x: 920,
			y: 105,	
	
			format : 'd/m/Y',
			allowBlank: false,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls: 'name',
					
		});
		var txtFechaBaja = new Ext.form.DateField({
			name: 'txtFechaBaja',
			hideLabel: true, 
			maxLength : 10,
			width: 91,
			y : 860,
			x: 110,		
			format : 'd/m/Y',
			//allowBlank: false,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls: 'name',
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
									
					}
				}
			}				
		});	
		var txtObservacion_baja = new Ext.form.TextField({
			name: 'txtObservacion_baja',
			//hideLabel: true,	
			maxLength : 250,
			width: 940,
			y : 890,
			x: 110,		
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
	    //requerimiento
		var txtFechaRequerimiento = new Ext.form.DateField({
			name: 'txtFechaRequerimiento',
			hideLabel: true, 
			maxLength : 10,
			width: 91,
			y : 765,
			x: 110,		
			format : 'd/m/Y',
			//allowBlank: false,		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls: 'name',
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
									
					}
				}
			}				
		});	
		var store_tipo_alta = new Ext.data.SimpleStore(
			{
				fields: ['codigop', 'nombrep'],
				data : [					
							['1', 'ALTA NUEVA'],			
							['2', 'REEMPLAZO']
					],   
				autoLoad: false 		
		});	
	
		var cbotipo_alta= new Ext.form.ComboBox(
		{  
			y : 765,
			x: 390,	 				
			width : 100,
			store: store_tipo_alta, 
			mode: 'local',
			style : {textTransform: "uppercase"},
			emptyText:'TIPO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbotipo_alta',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name'
		});
		var txtReemplaza_requerimiento = new Ext.form.TextField({
			name: 'txtReemplaza_requerimiento',
			//hideLabel: true,	
			maxLength : 150,
			width: 380,
			y : 765,
			x: 670,		
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtObservacion_requerimiento = new Ext.form.TextField({
			name: 'txtObservacion_requerimiento',
			//hideLabel: true,	
			maxLength : 250,
			width: 940,
			y : 795,
			x: 110,		
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		function mostrarFecha(days,fecha){
			
			milisegundos=parseInt(35*24*60*60*1000);
			// var fecha_ingreso = fecha.split("-")
			
			 // var ano = parseInt(array_fechasol[0]); 
			 // var mes = parseInt(array_fechasol[1]); 
			 // var dia = parseInt(array_fechasol[2]);
 
		//	alert(fecha);
			
			day=fecha.getDate();
			// el mes es devuelto entre 0 y 11
			month=fecha.getMonth()+1;
			year=fecha.getFullYear();
		 
			//document.write("Fecha actual: "+day+"/"+month+"/"+year);
		// alert(fecha);
			//Obtenemos los milisegundos desde media noche del 1/1/1970
			tiempo=fecha.getTime();
			//alert(tiempo);
			//Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
			milisegundos=parseInt(days*24*60*60*1000);
			//Modificamos la fecha actual
			total=fecha.setTime(tiempo+milisegundos);
			day=fecha.getDate();
			month=fecha.getMonth()+1;
			year=fecha.getFullYear();
			if(day<10){day="0"+day}
			if(month<10){month="0"+month}
			fecha=day+"/"+month+"/"+year;
			//alert(fecha);
			txtFechaFin.setValue(fecha);
			//alert("Fecha modificada: "+day+"/"+month+"/"+year);
		}
		var tipo_contrato=0;
		var cboTipoContrato= new Ext.form.ComboBox(
		{	
			x: 370,
			y: 75,	 				
			width : 150,   		
			store: storeTipoContrato, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione MODALIDAD CONTRATO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbtipocontrato',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
				'select': function(cmb,record,index){
						
							  if(index==0)
							  {
								  tipo_contrato=1;
								txtFechaIngreso.setDisabled(false);
			  
								txtFechaFin.setDisabled(true);
								lblfechaRetir.setText("PERIODO DE PRUEBA:");
								
							  }
							   else
							  {
								tipo_contrato=2;
								txtFechaIngreso.setDisabled(false);
								txtFechaFin.setDisabled(false);
								lblfechaRetir.setText("FECHA FINALIZACION:");
								
								
							  }
						
							
							}	
						 	    
			}		
			});	
		var storeRegionalDeTrabajo= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaRegionalTrabajoCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeRegionalDeTrabajo.load();

		var cboRegionalTrabajo= new Ext.form.ComboBox(
		{   		
			
			x: 110,
			y: 135,
			width : 150,
			store: storeRegionalDeTrabajo, 
			mode: 'local',
			//autocomplete : true,
			allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'REGION DE TRABAJO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbregiontrabajo',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
						   'select': function(cmb,record,index){
						   bandera1=0;
							cboOficina.setValue('');
							storeOficina.load({params:{cbRegion: cboRegionalTrabajo.getValue()}});	
							
							cboOficina.focus(true, 300);
							 cboOficina.enable(false);
							
							}	 
			}		
			});	
		var bandera1=1;
		var storeOficina= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaOficinaCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep', 'dirp', 'telfp'],
			listeners: { 		       
					load: function(thisStore, record, ids) 
					{  					
						if(bandera1==1)
						{
							 cboOficina.setValue(Ext.dsdata.storedatospersonal.getAt(ind).get('cod_oficina'));
							windatosPersonal.show();
							Ext.Msg.hide();
						}
						
					}
			}
		});		
		

		var cboOficina= new Ext.form.ComboBox(
		{   
			x: 340,
			y: 135,			
			width : 150,
			store: storeOficina, 
			mode: 'local',
			//autocomplete : true,
			//allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione OFICINA...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cboficina',
			selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
				'select': function(cmb,record,index){
				   // bandera1=0;
					// cboOficina.setValue('');
					// storeOficina.load({params:{cbRegion: cboRegionalTrabajo.getValue()}});	
					
					// cboOficina.focus(true, 300);
					 // cboOficina.enable(false);
					 console.log('hola mundo');
					 txtdireccionLaboral.setValue(storeOficina.getAt(index).get('dirp'));
					 txtTelefonoFijoLaboral.setValue(storeOficina.getAt(index).get('telfp'));
					
				}  		    
			}		
		});	
		
		
		var txtPorcentajeRango = new Ext.form.TextField({
				name: 'txtporcentaje_rango',
				width: 91,
				x: 620,
				y: 225,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
						}
					}
				}
		});	

		var RBvAplicaAguinaldo = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Aguinaldo',
			y : 495,
			x: 110,
			id:'rbaguinaldo',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					
					items: [
						{boxLabel: 'SI', id: 'idaguinaldo_si', name: 'rb-aguinaldo', inputValue: '1',checked: true,
							listeners: {
							  change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									
									if (Ext.getCmp('idaguinaldo_si').getValue() === true) {
										storeConceptos.each(function(record){
											if(record.data.id == 21){
												
												record.data.ticket=1;	
											}
											
										});
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										var i=0;
										storeConceptos.each(function(record){
		
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
											
											i++;
											
											
										});
										
										gridConceptos.getSelectionModel().selectRows(miArray, true);
										
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaguinaldo_no', name: 'rb-aguinaldo', inputValue: '2', 
							listeners: {
								change: function () {
									var pos = 0;  
		
									var miArray = new Array(); 
									miArray=[];
									
									
									if (Ext.getCmp('idaguinaldo_no').getValue() === true) {
										gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 21){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
		
						}
					]
				}]
		});
		var RBvAplicaAguinaldo2 = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Segundo Aguinaldo',
			y : 555,
			x: 110,
			id:'rbaguinaldo2',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idaguinaldo2_si', name: 'rb-aguinaldo2', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaguinaldo2_si').getValue() === true) {
										
										storeConceptos.each(function(record){
											if(record.data.id == 22){
												
												record.data.ticket=1;	
											}
											
										});
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										var i=0;
										storeConceptos.each(function(record){
		
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
											
											i++;
											
											
										});
										
										gridConceptos.getSelectionModel().selectRows(miArray, true);
										
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaguinaldo2_no', name: 'rb-aguinaldo2', inputValue: '2', 
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaguinaldo2_no').getValue() === true) {
										
										gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 22){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
		
						}
					]
				}]
		});
		var RBvAplicaPrima = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Prima',
			y : 495,
			x: 370,		 				
			
			id:'rbprima',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idprima_si', name: 'rb-prima', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idprima_si').getValue() === true) {
										storeConceptos.each(function(record){
											if(record.data.id == 23){
												
												record.data.ticket=1;	
											}
											
										});
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										var i=0;
										storeConceptos.each(function(record){
		
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
											
											i++;
											
											
										});
										
										gridConceptos.getSelectionModel().selectRows(miArray, true);
										
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idprima_no', name: 'rb-prima', inputValue: '2', 
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idprima_no').getValue() === true) {
										gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 23){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
		
						}
					]
				}]
		});

		var RBvAplicaRetroactivo = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Retroactivo',
			y : 585,
			x: 110,
			id:'rbretroactivo',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idretroactivo_si', name: 'rb-retroactivo', inputValue: '1',checked: true,
							listeners: {
								check: function () {
									if (Ext.getCmp('idretroactivo_si').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idretroactivo_no', name: 'rb-retroactivo', inputValue: '2', 
							listeners: {
								check: function () {
									if (Ext.getCmp('idretroactivo_no').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});
		val_aporte=1;
		val_afp=1;
		var RBvAplicaAportesPatronales = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Aportes Patronales',
			y : 465,
			x: 110,	 				
			
			id:'rbaportespatronales',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idaportes_patronales_si', name: 'rb-aportes_patronales', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaportes_patronales_si').getValue() === true) {
										
										storeConceptos.each(function(record){
											if(record.data.id == 14 || record.data.id == 15 || record.data.id == 16 || record.data.id == 17){
												
												record.data.ticket=1;	
											}
											
										});
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										var i=0;
										storeConceptos.each(function(record){
		
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
											
											i++;
											
											
										});
										
										gridConceptos.getSelectionModel().selectRows(miArray, true);
										
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaportes_patronales_no', name: 'rb-aportes_patronales', inputValue: '2', 
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaportes_patronales_no').getValue() === true) {
										
										
										gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 14 || record.data.id == 15 || record.data.id == 16 || record.data.id == 17){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
		
						}
					]
				}]
		});
		var RBvAplicaPlanillaTributaria = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Planilla Tributaria',
			y : 285,
			x: 110,	 				
			
			id:'rbaplica_planilla_tributaria',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idaplica_planilla_si', name: 'rb-aplica_planilla', inputValue: '1',checked: true,
							listeners: {
								check: function () {
									if (Ext.getCmp('idaplica_planilla_si').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaplica_planilla_no', name: 'rb-aplica_planilla', inputValue: '2', 
							listeners: {
								check: function () {
									if (Ext.getCmp('idaplica_planilla_no').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});
		var RBvAplicaIndemnizacion = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Indemnizacion',
			x: 660,
			y: 495,
			id:'rbindeminizacion',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idindemnizacion_si', name: 'rb-indemnizacion', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idindemnizacion_si').getValue() === true) {
										
										storeConceptos.each(function(record){
											if(record.data.id == 24){
												
												record.data.ticket=1;	
											}
											
										});
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										var i=0;
										storeConceptos.each(function(record){
		
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
											
											i++;
											
											
										});
										
										gridConceptos.getSelectionModel().selectRows(miArray, true);
										
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idindemnizacion_no', name: 'rb-indemnizacion', inputValue: '2', 
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idindemnizacion_no').getValue() === true) {
										gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 24){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
		
						}
					]
				}]
		});
	
		var RBvSindicalizado = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Sindicalizado', 				
			x: 890,
			y: 165,
			id:'rbsindicalizado',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idsindicalizado_si', name: 'rb-sindicalizado', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									if (Ext.getCmp('idsindicalizado_si').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idsindicalizado_no', name: 'rb-sindicalizado', inputValue: '2', 
							listeners: {
								change: function () {
									if (Ext.getCmp('idsindicalizado_no').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});
		var RBvAplicaInfocal = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Infocal',
			y : 615,
			x: 110,
			id:'rbsinfocal',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idaplica_infocal_si', name: 'rb-infocal', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaplica_infocal_si').getValue() === true) {
										
										storeConceptos.each(function(record){
											if(record.data.id == 25){
												
												record.data.ticket=1;	
											}
											
										});
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										var i=0;
										storeConceptos.each(function(record){
		
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
											
											i++;
											
											
										});
										
										gridConceptos.getSelectionModel().selectRows(miArray, true);
										
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaplica_infocal_no', name: 'rb-infocal', inputValue: '2', 
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaplica_infocal_no').getValue() === true) {
										gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 25){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
									}
								}
							}
		
						}
					]
				}]
		});
		var storefuente_min_eco = new Ext.data.SimpleStore(
			{
				fields: ['codigop', 'nombrep'],
				data : [					
							['1', '41 TRANSF-TGN'],			
							['2', '20 RECESP']
					],   
				autoLoad: false 		
		});	
	
			var cbofuente_min_eco= new Ext.form.ComboBox(
			{  
				
				x: 430,
				y: 615,				
				width : 120,
				store: storefuente_min_eco, 
				mode: 'local',
				//autocomplete : true,
			//	allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'FUENTE...',  
				hidden:true, 
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cbofuente_min_eco',
				//selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
								'select': function(cmb,record,index){
								
								
								}	 
				}		
			});
		
			var storeorganismo_min_eco = new Ext.data.SimpleStore(
				{
					fields: ['codigop', 'nombrep'],
					data : [					
								['1', '113 TGN-PP'],			
								['2', '119 TGN – IDH'],
								['3', '210 RECESPMUN']
						],   
					autoLoad: false 		
			});	
		
				var cboorganismo_min_eco= new Ext.form.ComboBox(
				{  
					
					x: 760,
					y: 615,				
					width : 120,
					store: storeorganismo_min_eco, 
					mode: 'local',
					hidden:true,
					//autocomplete : true,
				//	allowBlank: false,
					style : {textTransform: "uppercase"},
					emptyText:'ORGANISMO...',   
					triggerAction: 'all',   		
					displayField:'nombrep',   
					//typeAhead: true,
					valueField: 'codigop',
					hiddenName : 'cboorganismo_min_eco',
					//selectOnFocus: true,
					forceSelection:true,
					cls: 'name',
					listeners: {
									'select': function(cmb,record,index){
									
									
									}	 
					}		
				});
		var txtcodigo_dependiente_rc_iva = new Ext.form.TextField({
			name: 'txtcodigo_dependiente_rc_iva',
			maxLength : 30,
			width: 150,
			y : 285,
			x: 370,	 
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});	
		var store_tipo_novedad_rc_iva = new Ext.data.SimpleStore(
			{
				fields: ['codigop', 'nombrep'],
				data : [					
							['1', 'DESVINCULADO'],			
							['2', 'INGRESO'],
							['3', 'VIGENTE'],
							['4', 'INGRESO / DESVINCULADO']
					],   
				autoLoad: false 		
		});	
	
			var cbotipo_novedad_rc_iva= new Ext.form.ComboBox(
			{  
				x: 650,
				y: 285,	 				
				width : 150,
				store: store_tipo_novedad_rc_iva, 
				mode: 'local',
				//autocomplete : true,
			//	allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'TIPO NOVEDAD...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cbotipo_novedad_rc_iva',
				//selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
								'select': function(cmb,record,index){
								
								
								}	 
				}		
			});
		var RBvAplicaAportesSindicales1 = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Aportes Sindicales 1',
			y : 375,
			x: 110,	 				
			hidden:true,
			id:'rbaportes_sindicales1',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idaplica_aportes_sindicales1_si', name: 'rb-aportes_sindicales1', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									if (Ext.getCmp('idaplica_aportes_sindicales1_si').getValue() === true) {
										
										txtmonto_aportes_sindicales1.setDisabled(false);
										Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setDisabled(false);
										Ext.getCmp('idtipoaportes_sindicales1_fijo').setDisabled(false);
										
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaplica_aportes_sindicales1_no', name: 'rb-aportes_sindicales1', inputValue: '2', 
							listeners: {
								change: function () {
									if (Ext.getCmp('idaplica_aportes_sindicales1_no').getValue() === true) {
										
										txtmonto_aportes_sindicales1.setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales1_fijo').setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});
		var RBvtipoAportesSindicales1 = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			y : 375,
			x: 370,	 				
			hidden:true,
			id:'rbtipoaportes_sindicales1',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: '%', id: 'idtipoaportes_sindicales1_porcentaje', name: 'rb-tipo_aportes_sindicales1', inputValue: '1',checked: true,
							listeners: {
								check: function () {
									if (Ext.getCmp('idtipoaportes_sindicales1_porcentaje').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">FIJO</a>', id: 'idtipoaportes_sindicales1_fijo', name: 'rb-tipo_aportes_sindicales1', inputValue: '2', 
							listeners: {
								check: function () {
									if (Ext.getCmp('idtipoaportes_sindicales1_fijo').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});
		var txtmonto_aportes_sindicales1 = new Ext.form.NumberField({
			allowDecimals: true,
			hidden:true,
			allowBlank: false,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtmonto_aportes_sindicales1',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			x: 650,
			y: 375,
			width: 150,
			value : 0,
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});

		var RBvAplicaAportesSindicales2 = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Aportes Sindicales 2',
			y : 405,
			x: 110,	 				
			hidden:true,
			id:'rbaportes_sindicales2',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idaplica_aportes_sindicales2_si', name: 'rb-aportes_sindicales2', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									if (Ext.getCmp('idaplica_aportes_sindicales2_si').getValue() === true) {
										txtmonto_aportes_sindicales2.setDisabled(false);
										Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setDisabled(false);
										Ext.getCmp('idtipoaportes_sindicales2_fijo').setDisabled(false);
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaplica_aportes_sindicales2_no', name: 'rb-aportes_sindicales2', inputValue: '2', 
							listeners: {
								change: function () {
									if (Ext.getCmp('idaplica_aportes_sindicales2_no').getValue() === true) {
										
										txtmonto_aportes_sindicales2.setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales2_fijo').setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});
		var RBvtipoAportesSindicales2 = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			y : 405,
			x: 370,	 				
			hidden:true,
			id:'rbtipoaportes_sindicales2',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: '%', id: 'idtipoaportes_sindicales2_porcentaje', name: 'rb-tipo_aportes_sindicales2', inputValue: '1',checked: true,
							listeners: {
								check: function () {
									if (Ext.getCmp('idtipoaportes_sindicales2_porcentaje').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">FIJO</a>', id: 'idtipoaportes_sindicales2_fijo', name: 'rb-tipo_aportes_sindicales2', inputValue: '2', 
							listeners: {
								check: function () {
									if (Ext.getCmp('idtipoaportes_sindicales2_fijo').getValue() === true) {
										
										//cmbOrigenFondoCG.setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});
		var txtmonto_aportes_sindicales2 = new Ext.form.NumberField({
			allowDecimals: true,
			hidden:true,
			allowBlank: false,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtmonto_aportes_sindicales2',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			x: 650,
			y: 405,
			width: 150,
			value : 0,
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});

		var store_forma_pago = new Ext.data.SimpleStore(
				{
					fields: ['codigop', 'nombrep'],
					data : [					
								['1', 'BANCO'],			
								['2', 'CHEQUE'],
								['3', 'EFECTIVO']
						],   
					autoLoad: false 		
			});	
		
				var cboforma_pago= new Ext.form.ComboBox(
				{  
					y : 705,
					x: 110,				
					width : 150,
					store: store_forma_pago, 
					mode: 'local',
					//autocomplete : true,
				//	allowBlank: false,
					style : {textTransform: "uppercase"},
					emptyText:'FORMA DE PAGO...',   
					triggerAction: 'all',   		
					displayField:'nombrep',   
					//typeAhead: true,
					valueField: 'codigop',
					hiddenName : 'cboforma_pago',
					//selectOnFocus: true,
					forceSelection:true,
					cls: 'name',
					listeners: {
									'select': function(cmb,record,index){
									
									
									}	 
					}		
				});	
				var store_tipo_cuenta = new Ext.data.SimpleStore(
					{
						fields: ['codigop', 'nombrep'],
						data : [					
									['1', 'CAJA DE AHORRO'],			
									['2', 'CUENTA CORRIENTE']
							],   
						autoLoad: false 		
				});	
			
					var cbotipo_cuenta= new Ext.form.ComboBox(
					{  
						x: 635,
						y: 705,	 				
						width : 150,
						store: store_tipo_cuenta, 
						mode: 'local',
						//autocomplete : true,
					//	allowBlank: false,
						style : {textTransform: "uppercase"},
						emptyText:'TIPO DE CUENTA...',   
						triggerAction: 'all',   		
						displayField:'nombrep',   
						//typeAhead: true,
						valueField: 'codigop',
						hiddenName : 'cbotipo_cuenta',
						//selectOnFocus: true,
						forceSelection:true,
						cls: 'name',
						listeners: {
										'select': function(cmb,record,index){
										
										
										}	 
						}		
					});
			
					var store_motivo_retiro = new Ext.data.SimpleStore(
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
				
						var cbomotivo_retiro= new Ext.form.ComboBox(
						{  
							y : 860,
							x: 390,	 				
							width : 660,
							store: store_motivo_retiro, 
							mode: 'local',
							//autocomplete : true,
						//	allowBlank: false,
							style : {textTransform: "uppercase"},
							emptyText:'MOTIVO...',   
							triggerAction: 'all',   		
							displayField:'nombrep',   
							//typeAhead: true,
							valueField: 'codigop',
							hiddenName : 'cbomotivo_retiro',
							//selectOnFocus: true,
							forceSelection:true,
							cls: 'name',
							listeners: {
											'select': function(cmb,record,index){
											
											
											}	 
							}		
						});
		
			var txtNroCuentaBanco = new Ext.form.NumberField({
				allowDecimals: true,
				allowNegative: false,
				name: 'txtNroCuentaBanco',
				hideLabel: true,		
				maxLength : 20,	
				align: 'right',
				width: 150,
				x: 905,
				y: 705,
				value : 0,
				style : {textTransform: "uppercase"},			
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
							txtCantidadC.focus(true, 300);
						}
					}
				}
			});	

			var txtBancoParaElAbono = new Ext.form.TextField({
				name: 'txtBancoParaElAbono',
				//hideLabel: true,	
				maxLength : 150,
				width: 150,
				y : 705,
				x: 390,		
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});
		///costeo
		var txtPlanta_Costeo = new Ext.form.TextField({
			name: 'txtPlanta_Costeo',	
			maxLength : 150,
			width: 200,
			y : 555,
			x: 700,		
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtProceso_Costeo = new Ext.form.TextField({
			name: 'txtProceso_Costeo',	
			maxLength : 150,
			width: 200,
			y : 585,
			x: 700,		
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txttipo_Costeo = new Ext.form.TextField({
			name: 'txttipo_Costeo',	
			maxLength : 150,
			width: 200,
			y : 615,
			x: 700,		
			style : {textTransform: "uppercase"},
			blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		//////
		var RBvAplica_afp = new Ext.form.RadioGroup({
			xtype: 'radiogroup',
			fieldLabel: 'Aplica Afp',
			y : 345,
			x: 110,	
						
			id:'rbaplica_afp',
			items: [{
					xtype: 'radiogroup',
					width : 150,
					items: [
						{boxLabel: 'SI', id: 'idaplica_afp_si', name: 'rb-aplica_afp', inputValue: '1',checked: true,
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaplica_afp_si').getValue() === true) {
										
										storeConceptos.each(function(record){
											if(record.data.id == 10 || record.data.id == 11 || record.data.id == 12 || record.data.id == 13 || record.data.id == 18){
												
												record.data.ticket=1;	
											}
											
										});
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										var i=0;
										storeConceptos.each(function(record){
		
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
											
											i++;
											
											
										});
										
										gridConceptos.getSelectionModel().selectRows(miArray, true);
										
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										
										//cmbOrigenFondoCG.setDisabled(false);
									}
								}
							}
						},
						{boxLabel: 'NO', id: 'idaplica_afp_no', name: 'rb-aplica_afp', inputValue: '2', 
							listeners: {
								change: function () {
									var pos = 0;  
									var miArray = new Array(); 
									miArray=[];
									if (Ext.getCmp('idaplica_afp_no').getValue() === true) {
										
										gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 10 || record.data.id == 11 || record.data.id == 12 || record.data.id == 13 || record.data.id == 18){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										//cmbOrigenFondoCG.setDisabled(true);
									}
								}
							}
		
						}
					]
				}]
		});

		var txtNUA = new Ext.form.NumberField({
			allowDecimals: true,
			allowNegative: false,
			name: 'txtNUA',
			hideLabel: true,		
            maxLength : 20,	
			align: 'right',
			width: 150,
			x: 650,
			y: 345,	
			value : 0,
			style : {textTransform: "uppercase"},			
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var storeAFP= new Ext.data.JsonStore(
			{   
				url:'../servicesAjax/DSListaAFPCBAjax.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep']			
			});		
			storeAFP.load();
			var cboAFP = new Ext.form.ComboBox({   	
				width: 150,
				y : 345,
				x: 370,
				store: storeAFP,
						
				mode: 'local',
				//autocomplete : true,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'Seleccione AFP...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cboAFP',
				//selectOnFocus: true,
				forceSelection:true,
				cls:"name",
				listeners: {
						
							}						
				}		
			);
		
			var storeTIPOAFP= new Ext.data.JsonStore(
				{   
					url:'../servicesAjax/DSListaTIPOAFPCBAjax.php',   
					root: 'data',  
					totalProperty: 'total',
					fields: ['codigop', 'nombrep']			
				});		
				storeTIPOAFP.load();
			var cboTIPOAFP = new Ext.form.ComboBox({   
				y : 375,
				x: 110,	
					
				width : 450,
				store: storeTIPOAFP,
						
				mode: 'local',
				//autocomplete : true,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'Seleccione Tipo AFP...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cboTIPOAFP',
				//selectOnFocus: true,
				forceSelection:true,
				cls:"name",
				listeners: {
						
							}						
				}		
			);
		
			var storeTipoNovedadAFP = new Ext.data.SimpleStore(
				{
					fields: ['codigoge', 'desge'],
					data : [					
								['1', 'INGRESO'],			
								['2', 'RETIRO'],
								['3', 'LICENCIA NO REMUNERADA'],
								['4', 'SUBSIDIO R. COMUN Y/O R. PROF.']
								//['5', 'NINGUNO'],
							
						],   
					autoLoad: false 		
				});
				var cboTipoNovedad = new Ext.form.ComboBox({   	
					width: 150,
					y : 405,
					x: 110,
					store: storeTipoNovedadAFP,
							
					mode: 'local',
					style : {textTransform: "uppercase"},
					emptyText:'Tipo Novedad...',   
					triggerAction: 'all',   		
					displayField:'desge',   
					typeAhead: true,
					valueField: 'codigoge',
					hiddenName : 'cboTipoNovedad',
					selectOnFocus: true,
					forceSelection:true,
					cls:"name",
					listeners: {
							
								}						
					}		
				);
				var storeTipoAsegurado = new Ext.data.SimpleStore(
					{
						fields: ['codigoge', 'desge'],
						data : [		
									['4', 'NORMAL'],			
									['1', 'MINERO'],			
									['2', 'ESTACIONAL'],
									['3', 'CONSULTOR DE LINEA']
							],   
						autoLoad: false 		
					});
				var cboTipoAsegurado = new Ext.form.ComboBox({   	
					width: 150,
					y : 405,
					x: 650,
					store: storeTipoAsegurado,
							
					mode: 'local',
					style : {textTransform: "uppercase"},
					emptyText:'Tipo Asegurado...',   
					triggerAction: 'all',   		
					displayField:'desge',   
					typeAhead: true,
					valueField: 'codigoge',
					hiddenName : 'cboTipoAsegurado',
					selectOnFocus: true,
					forceSelection:true,
					cls:"name",
					listeners: {
							
								}						
					}		
				);
			var RBvEstaJubilado = new Ext.form.RadioGroup({
				xtype: 'radiogroup',
				fieldLabel: 'Esta jubilado',
				x: 680,
				y: 375,	
				id:'rbesta_jubilado',
				items: [{
						xtype: 'radiogroup',
						width : 150,
						items: [
							{boxLabel: 'SI', id: 'idesta_jubilado_si', name: 'rb-jubilado', inputValue: '1',checked: true,
								listeners: {
									check: function () {
										if (Ext.getCmp('idesta_jubilado_si').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(false);
										}
									}
								}
							},
							{boxLabel: 'NO', id: 'idesta_jubilado_no', name: 'rb-jubilado', inputValue: '2', 
								listeners: {
									check: function () {
										if (Ext.getCmp('idesta_jubilado_no').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(true);
										}
									}
								}
			
							}
						]
					}]
			});

			var RBvAporta_a_la_afp = new Ext.form.RadioGroup({
				xtype: 'radiogroup',
				fieldLabel: 'Aporta a la Afp',
				x: 905,
				y: 375,				
				id:'rbaporta_a_la_afp',
				items: [{
						xtype: 'radiogroup',
						width : 150,
						items: [
							{boxLabel: 'SI', id: 'idaporta_afp_si', name: 'rb-aporta_afp', inputValue: '1',checked: true,
								listeners: {
									change: function () {
										var pos = 0;  
										var miArray = new Array(); 
										miArray=[];
										if (Ext.getCmp('idaporta_afp_si').getValue() === true) {
											storeConceptos.each(function(record){
												if(record.data.id == 10){
													
													record.data.ticket=1;	
												}
												
											});
											var chx = Ext.getCmp('gridConceptos'); 
											chx.getStore().commitChanges();
											chx.getView().refresh();
											var i=0;
											storeConceptos.each(function(record){
			
												if(parseInt(record.data.ticket) == 1){  
													miArray[pos] = i;  
													pos++;  
												}  
												
												i++;
												
												
											});
											
											gridConceptos.getSelectionModel().selectRows(miArray, true);
											
											var chx = Ext.getCmp('gridConceptos'); 
											chx.getStore().commitChanges();
											chx.getView().refresh();
										}
									}
								}
							},
							{boxLabel: 'NO', id: 'idaporta_afp_no', name: 'rb-aporta_afp', inputValue: '2', 
								listeners: {
									change: function () {
										var pos = 0;  
										var miArray = new Array(); 
										miArray=[];
										if (Ext.getCmp('idaporta_afp_no').getValue() === true) {
											gridConceptos.getSelectionModel().selectRows(miArray, false);
										storeConceptos.each(function(record){
											if(record.data.id == 10){
												record.data.ticket=0;	
											}
											
										});
										var i=0;
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										storeConceptos.each(function(record){
											if(parseInt(record.data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											} 
			
											i++;
											
										});
										gridConceptos.getSelectionModel().selectRows(miArray, true);
									
										var chx = Ext.getCmp('gridConceptos'); 
										chx.getStore().commitChanges();
										chx.getView().refresh();
										}
									}
								}
			
							}
						]
					}]
			});

			var RBvEsPersonaConDiscapacidad = new Ext.form.RadioGroup({
				xtype: 'radiogroup',
				fieldLabel: 'Es persona con discapacidad',
				y : 645,
				x: 110,			
				id:'rbes_persona_con_discapacidad',
				items: [{
						xtype: 'radiogroup',
						width : 150,
						items: [
							{boxLabel: 'SI', id: 'ides_persona_con_discapacidad_si', name: 'rb-persona_discapacidad', inputValue: '1',checked: true,
								listeners: {
									check: function () {
										if (Ext.getCmp('ides_persona_con_discapacidad_si').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(false);
										}
									}
								}
							},
							{boxLabel: 'NO', id: 'ides_persona_con_discapacidad_no', name: 'rb-persona_discapacidad', inputValue: '2', 
								listeners: {
									check: function () {
										if (Ext.getCmp('ides_persona_con_discapacidad_no').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(true);
										}
									}
								}
			
							}
						]
					}]
			});
		
			var RBvEsTutorDePersonaConDisc = new Ext.form.RadioGroup({
				xtype: 'radiogroup',
				fieldLabel: 'Es tutor de persona con discapacidad',
				y : 645,
				x: 390,	
				id:'rbtutor_de_persona_con_disc',
				items: [{
						xtype: 'radiogroup',
						width : 150,
						items: [
							{boxLabel: 'SI', id: 'ides_tutor_si', name: 'rb-tutor', inputValue: '1',checked: true,
								listeners: {
									check: function () {
										if (Ext.getCmp('ides_tutor_si').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(false);
										}
									}
								}
							},
							{boxLabel: 'NO', id: 'ides_tutor_no', name: 'rb-tutor', inputValue: '2', 
								listeners: {
									check: function () {
										if (Ext.getCmp('ides_tutor_no').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(true);
										}
									}
								}
			
							}
						]
					}]
			});
			var txtFechaNovedad= new Ext.form.DateField({
				
				name: 'txtFechaNovedad',
				hideLabel: true, 
				maxLength : 10,
				width: 91,
				y : 405,
				x: 370,	
				format : 'd/m/Y',
				allowBlank: true,		
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
										
						}
					}
				}				
			});
			var txtNumeroAsegurado = new Ext.form.TextField({
				name: 'txtNumeroAsegurado',
				//hideLabel: true,	
				maxLength : 150,
				width: 150,
		
				x: 890,
				y: 345,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				cls:"name",
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
		var storeJefeDirecto= new Ext.data.JsonStore(
			{   
				url:'../servicesAjax/DSListaPersonalAjax.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep']			
			});		
			storeJefeDirecto.load();
	
			var cboJefeDirecto= new Ext.form.ComboBox(
			{   		
				y : 195,
				x: 110,	 	
				width : 150,
				store: storeJefeDirecto, 
				mode: 'local',
				//autocomplete : true,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'Seleccione Jefe Directo...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cbojefedirecto',
				selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
								
				}		
			});
			var storeJefeArea= new Ext.data.JsonStore(
				{   
					url:'../servicesAjax/DSListaPersonalAjax.php',   
					root: 'data',  
					totalProperty: 'total',
					fields: ['codigop', 'nombrep']			
				});		
				storeJefeArea.load();
		
				var cboJefeArea= new Ext.form.ComboBox(
				{   		
					width: 150,
					x: 370,
					y: 195,
					store: storeJefeArea, 
					mode: 'local',
					//--autocomplete : true,
					//allowBlank: false,
					style : {textTransform: "uppercase"},
					emptyText:'Seleccione Jefe Area...',   
					triggerAction: 'all',   		
					displayField:'nombrep',   
					//typeAhead: true,
					valueField: 'codigop',
					hiddenName : 'cbojefearea',
					cls: 'name',
					selectOnFocus: true,
					forceSelection:true,
					listeners: {
										
					}		
				});	
				var storeGerenteArea= new Ext.data.JsonStore(
					{   
						url:'../servicesAjax/DSListaPersonalAjax.php',   
						root: 'data',  
						totalProperty: 'total',
						fields: ['codigop', 'nombrep']			
					});		
					storeGerenteArea.load();
			
					var cboGerenteArea= new Ext.form.ComboBox(
					{   		
						y : 195,
						x: 650,		
						width : 150,
						store: storeGerenteArea, 
						mode: 'local',
						//autocomplete : true,
						//allowBlank: false,
						style : {textTransform: "uppercase"},
						emptyText:'Seleccione Gerente Area...',   
						triggerAction: 'all',   		
						displayField:'nombrep',   
						//typeAhead: true,
						valueField: 'codigop',
						hiddenName : 'cbogerenteArea',
						selectOnFocus: true,
						forceSelection:true,
						cls: 'name',
						listeners: {
										
						}		
					});
					var txtcelularCorporativo  = new Ext.form.TextField({
						name: 'txtcelularCorporativo',
						maxLength : 50,
						width: 150,
						y : 225,
						x: 110,	 
						style : {textTransform: "uppercase"},
						blankText: 'Campo requerido',
						enableKeyEvents: true,
						selectOnFocus: true,
						cls:"name",
						listeners: {
							keypress: function(t,e){
								if(e.getKey()==13){
									
								}
							}
						}
				});	

				var txtCorreoCorporativo  = new Ext.form.TextField({
					name: 'txtcorreo_corporativo',
					maxLength : 50,
					width: 150,
					x: 370,
					y: 225,
					style : {textTransform: "uppercase"},
					blankText: 'Campo requerido',
					enableKeyEvents: true,
					selectOnFocus: true,
					cls:"name",
					listeners: {
						keypress: function(t,e){
							if(e.getKey()==13){
								
							}
						}
					}
			});	
		
		var storeNivelJerarquico= new Ext.data.JsonStore(
		{   
			url:'../servicesAjax/DSListaNivelCBAjax.php',   
			root: 'data',  
			totalProperty: 'total',
			fields: ['codigop', 'nombrep']			
		});		
		storeNivelJerarquico.load();

		var cboNivelJerarquico= new Ext.form.ComboBox(
		{   				
			width : 300,
			y : 225,
			x: 950,		
			//hidden:true,
			store: storeNivelJerarquico, 
			mode: 'local',
			//autocomplete : true,
			// allowBlank: false,
			style : {textTransform: "uppercase"},
			emptyText:'Seleccione NIVEL JERARQUICO...',   
			triggerAction: 'all',   		
			displayField:'nombrep',   
			//typeAhead: true,
			valueField: 'codigop',
			hiddenName : 'cbonivel',
			//selectOnFocus: true,
			forceSelection:true,
			cls: 'name',
			listeners: {
						  // 'select': function(cmb,record,index){
							// cboCiudad.setValue('');
							// storeCiudad.load({params:{cbpais: cboPais.getValue()}});	
							
							// cboCiudad.focus(true, 300);
							 // cboCiudad.enable(false);
							
							// }		    
			}		
			});	
			// var txtSueldoBasico = new Ext.form.TextField({
				// name: 'txtsueldobasico',
				// x: 140,
				// y: 255,
				// width: 91,
			    // allowBlank: false,
				// style : {textTransform: "uppercase"},
				// blankText: 'Campo requerido',
				// enableKeyEvents: true,
				// selectOnFocus: true,
				// cls: 'name',
				// listeners: {
					// keypress: function(t,e){
						
					// }
				// }
		// });	
		//REMUNERACION
			var txtSueldoBasico = new Ext.form.NumberField({
				allowDecimals: true,
				allowBlank: true,//angelo
				decimalPrecision :2,
				allowNegative: false,
				name: 'txtsueldobasico',
				hideLabel: true,		
				maxLength : 20,	
				align: 'right',
				forceDecimalPrecision : true,
				x: 140,
				y: 15,
				width: 150,
				value : 0,
				style: 'text-align: right',		
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"numero",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
							
						}
					}
				}
			});	
			var txtVariableBase = new Ext.form.NumberField({
				allowDecimals: true,
				//allowBlank: false,
				decimalPrecision :2,
				allowNegative: false,
				name: 'txtVariableBase',
				hideLabel: true,		
				maxLength : 20,	
				align: 'right',
				forceDecimalPrecision : true,
				x: 140,
				y: 45,
				width: 150,
				value : 0,
				style: 'text-align: right',		
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"numero",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
							
						}
					}
				}
			});	
			var RBvBonoAntiguedad = new Ext.form.RadioGroup({
				xtype: 'radiogroup',
				fieldLabel: 'Bono Antiguedad',
				y : 45,
				x: 140,	 				
				hidden:true,
				id:'rbBonoAntiguedad',
				items: [{
						xtype: 'radiogroup',
						width : 500,
						
						items: [
							{boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">FECHA INGRESO</a>', id: 'idbono_antiguedad_si', name: 'rb-bono_antiguedad', inputValue: '1',checked: true,
								listeners: {
									check: function () {
										if (Ext.getCmp('idbono_antiguedad_si').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(false);
										}
									}
								}
							},
							{boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">FECHA INGRESO PARA BONO ANTIGUEDAD</a>', id: 'idbono_antiguedad_no', name: 'rb-bono_antiguedad', inputValue: '2', 
								listeners: {
									check: function () {
										if (Ext.getCmp('idbono_antiguedad_no').getValue() === true) {
											
											//cmbOrigenFondoCG.setDisabled(true);
										}
									}
								}
			
							}
						]
					}]
			});
			var storeDominical = new Ext.data.SimpleStore(
				{
					fields: ['codigop', 'nombrep'],
					data : [					
								['1', 'CON DOMINICAL'],			
								['0', 'SIN DOMINICAL'],	
									
						],   
					autoLoad: false 		
				});	
				var cboDominical= new Ext.form.ComboBox(
				{   
					x: 440,
					y: 15,
					width : 150,
					store: storeDominical, 
					mode: 'local',
					//autocomplete : true,
					allowBlank: true,//angelo
					style : {textTransform: "uppercase"},
					emptyText:'Seleccione...',   
					triggerAction: 'all',   		
					displayField:'nombrep',   
					//typeAhead: true,
					valueField: 'codigop',
					hiddenName : 'cbdominical',
					//selectOnFocus: true,
					forceSelection:true,
					cls: 'name',
					listeners: {
						'select': function(cmb,record,index){
								dominical_aux=storeDominical.getAt(index).get('codigop');
									
								if(dominical_aux==0)
								{
									txtDomingosMes.setValue('0');
									txtDomingosMes.setDisabled(true);

								}
								else
								{
									//txtDomingosMes.setValue('0');
									txtDomingosMes.setDisabled(false);
									
								}
								//txtDomingosMes
							}	
										 
					}		
					});	

					var storeTipoVariable = new Ext.data.SimpleStore(
						{
							fields: ['codigop', 'nombrep'],
							data : [					
										['1', 'COMISION'],			
										['2', 'OTROS INGRESOS']	
								],   
							autoLoad: false 		
						});	
					var cboTipoVariable= new Ext.form.ComboBox(
						{   
							x: 440,
							y: 45,
							width : 150,
							store: storeTipoVariable, 
							mode: 'local',
							//autocomplete : true,
							
							style : {textTransform: "uppercase"},
							emptyText:'Seleccione...',   
							triggerAction: 'all',   		
							displayField:'nombrep',   
							//typeAhead: true,
							valueField: 'nombrep',
							hiddenName : 'cboTipoVariable',
							//selectOnFocus: true,
							forceSelection:true,
							cls: 'name',
							listeners: {
								'select': function(cmb,record,index){
										
									}	
													
							}		
							});	
					var bono_antiguedad_dif_check=0;
					var chkbonoAntiguedadDif = [
						{
							x: 650,
							y: 15,
						  xtype  : 'checkbox',
						  name: 'bono_antiguedad_dif',
						  id: 'bono_antiguedad_dif',
						  boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">BONO ANTIGUEDAD <BR> DIFERENCIADO 1.S.M.N.</a>',
						  inputValue : '0',
						  hidden:true,
						  checked: false,
						  handler: function() { 				
							  if (this.getValue() == true)
							  {
								
								cboBonoAntiguedad.setDisabled(false);
								bono_antiguedad_dif_check=1;
							  }
							  else
							  {
								cboBonoAntiguedad.setValue(0);
								cboBonoAntiguedad.setDisabled(true);
								bono_antiguedad_dif_check=0;
								
							  } 
						  } 		  
						}
					  ]

					  var storeBonoAntiguedad= new Ext.data.JsonStore(
						{   
							url:'../servicesAjax/DSListaCategoriaCas.php',   
							root: 'data',  
							totalProperty: 'total',
							fields: ['codigop', 'nombrep']			
						});		
						storeBonoAntiguedad.load();
				
						var cboBonoAntiguedad= new Ext.form.ComboBox(
						{   		 
							y : 15,
							x: 930,		
							width : 150,
							store: storeBonoAntiguedad, 
							mode: 'local',
							hidden:true,
							//autocomplete : true,
						//	allowBlank: false,
							style : {textTransform: "uppercase"},
							emptyText:'CATEGORIA...',   
							triggerAction: 'all',   		
							displayField:'nombrep',   
							//typeAhead: true,
							valueField: 'codigop',
							hiddenName : 'cboBonoAntiguedad',
							//selectOnFocus: true,
							forceSelection:true,
							cls: 'name',
							listeners: {
										   'select': function(cmb,record,index){
										  
											
											}	 
							}		
							});	
					var RBvAplicaQuincena = new Ext.form.RadioGroup({
						xtype: 'radiogroup',
						hidden:true,
						fieldLabel: 'Aplica Quincena',
						y : 105,
						x: 140,	 				
						
						id:'rbquincena',
						items: [{
								xtype: 'radiogroup',
								width : 150,
								items: [
									{boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">SI</a>', id: 'idquincena_si', name: 'rb-quincena', inputValue: '1',checked: true,
										listeners: {
											change: function () {
												if (Ext.getCmp('idquincena_si').getValue() === true) {
													
													txtmonto_aplica_quincena.setDisabled(false);
													Ext.getCmp('idtipoquincena_porcentaje').setDisabled(false);
													Ext.getCmp('idtipoquincena_monto').setDisabled(false);
												}
											}
										}
									},
									{boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">NO</a>', id: 'idquincena_no', name: 'rb-quincena', inputValue: '2', 
										listeners: {
											change: function () {
												if (Ext.getCmp('idquincena_no').getValue() === true) {
													
													txtmonto_aplica_quincena.setDisabled(true);
													Ext.getCmp('idtipoquincena_porcentaje').setDisabled(true);
													Ext.getCmp('idtipoquincena_monto').setDisabled(true);
												}
											}
										}
					
									}
								]
							}]
					});
					var RBvtipopagoAplicaQuincena = new Ext.form.RadioGroup({
						xtype: 'radiogroup',
						y : 105,
						x: 370,	 				
						hidden:true,
						id:'rbtipoquincena',
						items: [{
								xtype: 'radiogroup',
								width : 150,
								items: [
									{boxLabel: '%', id: 'idtipoquincena_porcentaje', name: 'rb-tipoquincena', inputValue: '1',checked: true,
										listeners: {
											check: function () {
												if (Ext.getCmp('idtipoquincena_porcentaje').getValue() === true) {
													
													//cmbOrigenFondoCG.setDisabled(false);
												}
											}
										}
									},
									{boxLabel: '<a style ="font: bold 10px tahoma,arial,verdana,sans-serif;">FIJO</a>', id: 'idtipoquincena_monto', name: 'rb-tipoquincena', inputValue: '2', 
										listeners: {
											check: function () {
												if (Ext.getCmp('idtipoquincena_monto').getValue() === true) {
													
													//cmbOrigenFondoCG.setDisabled(true);
												}
											}
										}
					
									}
								]
							}]
					});
					var txtmonto_aplica_quincena = new Ext.form.NumberField({
						allowDecimals: true,
						allowBlank: false,
						hidden:true,
						decimalPrecision :2,
						allowNegative: false,
						name: 'txtmonto_aplica_quincena',
						hideLabel: true,		
						maxLength : 20,	
						align: 'right',
						x: 650,
						y: 105,
						width: 150,
						value : 0,
						style : {textTransform: "uppercase"},			
						enableKeyEvents: true,
						selectOnFocus: true,
						cls:"name",
						listeners: {
							keypress: function(t,e){				
								if(e.getKey()==13){
									
								}
							}
						}
					});	
					
					var storeConceptos = new Ext.data.JsonStore(
						{
								url: '../servicesAjax/DSListadoRemuneracion.php',
								root: 'data',			
								totalProperty: 'total',
								fields: ['id', 'nombre','ntipo','ticket'],
								listeners: { 
									 load: function(thisStore, record, ids) { 
														
										var pos = 0;  
										var miArray = new Array();  
										gridConceptos.getSelectionModel().selectRows(record, false);
										for(i=0; i<this.getCount();i++){  
											if(parseInt(record[i].data.ticket) == 1){  
												miArray[pos] = i;  
												pos++;  
											}  
										}  			
										gridConceptos.getSelectionModel().selectRows(miArray, true);	
											
									}
				
								}	      
							
									
						});
						
						var smR = new Ext.grid.CheckboxSelectionModel({
						 checkOnly:true
						});
						var ColumnasRen = new Ext.grid.ColumnModel(  
						[
							{  
								header: 'Codigo',  
								dataIndex: 'id', 			
								width : 100,
								hidden: true
							}
							,{  
								header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Concepto</a>',
								dataIndex: 'nombre',  		
								width : 240
							},{  
								header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Tipo</a>', 
								dataIndex: 'ntipo',  		
								width : 130
							},
							smR
						
				
						
									
						]  
						);
						var gridConceptos = new Ext.grid.EditorGridPanel({  
							id: 'gridConceptos',			
							height:600,
							width : 430,
							x: 10,
							y: 80,
							store: storeConceptos,	
										
							cm: ColumnasRen, 			
							border: false,   
							enableColLock:false,
							stripeRows: false,				
							deferRowRender: false,
							
							sm: smR,
							
							destroy : function () {
								if (this.store) {
									this.store.destroyStore();
								}
								this.callParent();
							},
						});

			////////////////////////////////////

			
		var txtSueldoVariable = new Ext.form.TextField({
				name: 'txtsueldovariable',
				hidden:true,
				//hideLabel: true,	
				maxLength : 150,
				width: 91,
				x: 620,
				y: 255,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						
					}
				}
		});	
		var txtMinimo = new Ext.form.TextField({
				name: 'txtminimo',
				hidden:true,
				width: 91,
				x: 140,
				y: 285,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
					}
				}
		});	
		var txtMidPoint = new Ext.form.TextField({
				name: 'txtmidpoint',
				hidden:true,
				width: 91,
				x: 370,
				y: 285,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
		var txtMaximo = new Ext.form.TextField({
				name: 'txtmaximo',
				hidden:true,
				//hideLabel: true,	
				maxLength : 150,
				width: 91,
				x: 620,
				y: 285,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls: 'name',
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
		});	
			
		var txtEvolucionRango = new Ext.form.TextField({
				name: 'evolucion_rango',
				hidden:true,
				//hideLabel: true,	
				maxLength : 150,
				width: 150,
				x: 470,
				y: 225,
				//allowBlank: false,
				style : {textTransform: "uppercase"},
				blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							cboPais.focus(true, 300);
						}
					}
				}
		});
		
		
	
		//label
		var lblNroTrabajador = new Ext.form.Label({
			text: 'CODIGO :',
			x: 10,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblsubcentro = new Ext.form.Label({
			text: 'SUBCENTRO :',
			x: 270,
			y: 45,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
		});
		var lblplanilla = new Ext.form.Label({
			text: 'PLANILLA :',
			x: 270,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
		});
		var lbldominical = new Ext.form.Label({
			text: 'DOMINICAL:',
			x: 330,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
		});
		var lbltipodeVariable = new Ext.form.Label({
			text: 'TIPO VARIABLE:',
			x: 330,
			y: 45,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
		});
		var lblcategoria_certificada = new Ext.form.Label({
			text: '',
			x: 800,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			html:'CATEGORIA <BR>CERTIFICADA (CAS):'
		});
		var lblTipoEvaluacion = new Ext.form.Label({
			text: 'TIPO EVALUACION:',
			x: 530,
			y: 225,
			height: 20,
			cls: 'namelabel'
		});	
		var lblNivelJerarquico = new Ext.form.Label({
			text: 'NIVEL JERARQUICO:',
			x: 830,
			y: 225,
			height: 20,
			cls: 'namelabel'
		});	
		var lblunidad = new Ext.form.Label({
			text: 'UNIDAD :',
			x: 10,
			y: 45,
			// x: 350,
			// y: 15,
			height: 20,
			cls: 'namelabel',
		});	
		
		var lblaplica_retencion_impositiva = new Ext.form.Label({
			text: '',
			x: 530,
			y: 15,
			height: 20,
			cls: 'namelabel',
			html:'APLICA RETENCION <br>IMPOSITIVA :'
		});	
		var lblcentro = new Ext.form.Label({
			text: 'CENTRO DE COSTO :',
			x: 530,
			y: 45,
			height: 20,
			cls: 'namelabel',
		});	
		var lblcargo = new Ext.form.Label({
			text: 'CARGO :',
			x: 795,
			y: 45,
			height: 20,
			cls: 'namelabel',
		});	
		var lblhorario = new Ext.form.Label({
			text: 'HORARIO :',
			x: 10,
			y: 105,
			height: 20,
			cls: 'x-label'
		});	
		var lbltipoTrabjador = new Ext.form.Label({
			text: 'TIPO TRABAJADOR :',
			x: 10,
			y: 75,
			height: 20,
			cls: 'namelabel'
		});	
		var lblfechaParaVacacionesEspeciales = new Ext.form.Label({
			text: '',
			x: 270,
			y: 105,
			height: 20,
			cls: 'namelabel',
			html:'FECHA INGRESO <br>PARA VACACIONES :'
		});
		var lblfechaParaBonoAntiguedad = new Ext.form.Label({
			text: '',
			x: 530,
			y: 105,
			height: 20,
			cls: 'namelabel',
			html:'FECHA INGRESO <br>PARA BONO ANTIG. :'
		});
		var lblmodalidad_trabajo = new Ext.form.Label({
			text: '',
			x: 795,
			y: 75,
			height: 20,
			cls: 'namelabel',
			html:'MODALIDAD DE <br> TRABAJO :'
		});
		var lblclasificacion_laboral = new Ext.form.Label({
			text: '',
			x: 10,
			y: 165,
			height: 20,
			cls: 'namelabel',
			html:'CLASIFICACION <br> LABORAL :'
		});
		var lblmodalidad_contrato = new Ext.form.Label({
			text: '',
			x: 270,
			y: 75,
			height: 20,
			cls: 'namelabel',
			html:'MODALIDAD <br> CONTRATO :'
		});
		var lblaplica_quincena = new Ext.form.Label({
			text: '',
			x: 10,
			y: 105,
			height: 20,
			cls: 'namelabel',
			html:'APLICA <br>QUINCENA :'
		});
		var lblaplica_aguinaldo = new Ext.form.Label({
			text: '',
			x: 10,
			y: 495,
			height: 20,
			cls: 'namelabel',
			html:'APLICA <br>AGUINALDO :'
		});
		var lblaplica_retroactivo = new Ext.form.Label({
			text: '',
			x: 10,
			y: 585,
			height: 20,
			cls: 'namelabel',
			html:'APLICA <br>RETROACTIVO :'
		});
		var lblproceso_costeo = new Ext.form.Label({
			text: '',
			x: 600,
			y: 585,
			height: 20,
			cls: 'namelabel',
			html:'PROCESO :'
		});
		var lblaplica_indemnizacion = new Ext.form.Label({
			text: '',
			x: 560,
			y: 495,
			height: 20,
			cls: 'namelabel',
			html:'APLICA <br>INDEMNIZACION :'
		});
		var lblindemnizacion_pagada_hast = new Ext.form.Label({
			text: '',
			x: 815,
			y: 495,
			height: 20,
			cls: 'namelabel',
			html:'INDEMNIZACION<br>PAGADA HASTA :'
		});
		var lblaplica_infocal = new Ext.form.Label({
			text: '',
			x: 10,
			y: 615,
			height: 20,
			cls: 'namelabel',
			html:'APLICA INFOCAL :'
		});
		var lbltipo_costo = new Ext.form.Label({
			text: '',
			x: 600,
			y: 615,
			height: 20,
			cls: 'namelabel',
			html:'TIPO DE COSTO :'
		});
		var lblfuente_min = new Ext.form.Label({
			text: '',
			x: 270,
			y: 615,
			height: 20,
			cls: 'namelabel',
			html:'FUENTE <br>(MINISTERIO ECONOMIA) :'
		});
		var lblorganismo_min = new Ext.form.Label({
			text: '',
			x: 600,
			y: 615,
			height: 20,
			cls: 'namelabel',
			html:'ORGANISMO <br>(MINISTERIO ECONOMIA) :'
		});
		var lblaplica_aportes_sindicales1 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 375,
			height: 20,
			cls: 'namelabel',
			html:'APLICA A APORTES <br>SINDICALES 1 :'
		});
		var lblaplica_aportes_sindicales2 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 405,
			height: 20,
			cls: 'namelabel',
			html:'APLICA A APORTES <br>SINDICALES 2 :'
		});
		var lblforma_pago = new Ext.form.Label({
			text: '',
			x: 10,
			y: 705,
			height: 20,
			cls: 'namelabel',
			html:'FORMA DE <br>PAGO :'
		});
		var lblBancoParaSueldos = new Ext.form.Label({
			text: '',
			x: 285,
			y: 705,
			height: 20,
			cls: 'namelabel',
			html:'BANCO PARA<br> SUELDO :'
		});	
		var lblmotivo_baja = new Ext.form.Label({
			text: '',
			x: 285,
			y: 860,
			height: 20,
			cls: 'namelabel',
			html:'MOTIVO DEL<br>RETIRO :'
		});	
		var lblAFP = new Ext.form.Label({
			text: '',
			x: 270,
			y: 345,
			height: 20,
			cls: 'namelabel',
			html:'ADM. PENSIONES :'
		});	
		var lblEstaJubilado = new Ext.form.Label({
			text: '',
			x: 590,
			y: 375,
			height: 20,
			cls: 'namelabel',
			html:'ESTA JUBILADO :'
		});	
		var lblEsTutotDePersonaDiscapacidad = new Ext.form.Label({
			text: '',
			x: 270,
			y: 645,
			height: 20,
			cls: 'namelabel',
			html:'ES TUTOR DE PERSONA<BR>CON DISCAPACIDAD :'
		});	
		var lblJefeDirecto = new Ext.form.Label({
			text: '',
			x: 10,
			y: 195,
			height: 20,
			cls: 'namelabel',
			html:'JEFE DIRECTO :'
		});	
		var lblCelularCorporativo = new Ext.form.Label({
			text: '',
			x: 10,
			y: 225,
			height: 20,
			cls: 'namelabel',
			html:'CELULAR <br>CORPORATIVO :'

		});	
		var lblenun1 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 265,
			height: 20,
			cls: 'namelabel',
			html:'<B>IMPUESTOS</B>'

		});	
		var lblenun2 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 325,
			height: 20,
			cls: 'namelabel',
			html:'<B>SEGURIDAD SOCIAL</B>'

		});	
		var lblenun3 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 445,
			height: 20,
			cls: 'namelabel',
			html:'<B>CARGAS SOCIALES</B>'

		});	
		var lblenun4 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 535,
			height: 20,
			cls: 'namelabel',
			html:'<B>OTROS</B>'

		});	
		var lblenun5 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 685,
			height: 20,
			cls: 'namelabel',
			html:'<B>FORMA DE PAGO</B>'

		});	
		var lblenun6 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 830,
			height: 20,
			cls: 'namelabel',
			html:'<B>BAJA DEL TRABAJADOR</B>'

		});	
		var lblenun8 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 745,
			height: 20,
			cls: 'namelabel',
			html:'<B>REQUERIMIENTO DE PERSONAL</B>'

		});	
		var lblenun7 = new Ext.form.Label({
			text: '',
			x: 455,
			y: 460,
			height: 20,
			cls: 'namelabel',
			html:'<B>PROMOCIONES INTERNAS / REEMPLAZOS</B>'

		});	
		var lblenun9 = new Ext.form.Label({
			text: '',
			x: 600,
			y: 535,
			height: 20,
			cls: 'namelabel',
			html:'<B>COSTEO</B>'

		});	
		var lblaplica_aguinaldo2 = new Ext.form.Label({
			text: '',
			x: 10,
			y: 555,
			height: 20,
			cls: 'namelabel',
			html:'APLICA SEGUNDO<br> AGUINALDO :'
		});
		var lblplanta_costeo = new Ext.form.Label({
			text: '',
			x: 600,
			y: 555,
			height: 20,
			cls: 'namelabel',
			html:'PLANTA :'
		});
		var lblaplica_aportes_patronales = new Ext.form.Label({
			text: '',
			x: 10,
			y: 465,
			height: 20,
			cls: 'namelabel',
			html:'APLICA APORTES<br> PATRONALES :'
		});
		var lblsindicalizado = new Ext.form.Label({
			text: '',
			x: 795,
			y: 165,
			height: 20,
			cls: 'namelabel',
			html:'SINDICALIZADO :'
		});
		var lbltipo_monto_aportes_sindiales1 = new Ext.form.Label({
			text: '',
			x: 270,
			y: 375,
			height: 20,
			cls: 'namelabel',
			html:'TIPO MONTO:'
		});
		var lbltipo_monto_aportes_sindiales2 = new Ext.form.Label({
			text: '',
			x: 270,
			y: 405,
			height: 20,
			cls: 'namelabel',
			html:'TIPO MONTO:'
		});
		var lbltipo_de_cuenta = new Ext.form.Label({
			text: '',
			x: 560,
			y: 705,
			height: 20,
			cls: 'namelabel',
			html:'TIPO DE<BR> CUENTA :'
		});
		var lblaplica_afp = new Ext.form.Label({
			text: '',
			x: 10,
			y: 345,
			height: 20,
			cls: 'namelabel',
			html:'APLICA AFP :'
		});
		var lblTIPO_APORTE_AFP = new Ext.form.Label({
			text: 'TIPO APORTE AFP :',
			x: 10,
			y: 375,
			height: 20,
			cls: 'namelabel'
		});	
		var lblaporta_afp= new Ext.form.Label({
			text: '',
			x: 830,
			y: 375,
			
			height: 20,
			cls: 'namelabel',
			html:'APORTA A LA<BR> AFP :'
		});	
		var lblNROASEGURADO = new Ext.form.Label({
			text: '',
			x: 815,
			y: 345,
			height: 20,
			cls: 'namelabel',
			html:'NRO DE <br>ASEGURADO :'
		});	
		var lblfecha_novedad = new Ext.form.Label({
			text: '',
			x: 270,
			y: 405,
			height: 20,
			cls: 'namelabel',
			html:'FECHA NOVEDAD :'
		});	
		var lbltipo_asegurado = new Ext.form.Label({
			text: '',
			x: 520,
			y: 405,
			height: 20,
			cls: 'namelabel',
			html:'TIPO ASEGURADO AFP:'
		});	
		var lblJefeArea = new Ext.form.Label({
			text: '',
			x: 270,
			y: 195,
			height: 20,
			cls: 'namelabel',
			html: 'JEFE DE AREA :',
		});	
		var lblCorreoCorporativo = new Ext.form.Label({
			text: '',
			x: 270,
			y: 225,
			height: 20,
			cls: 'namelabel',
			html: 'CORREO <br>CORPORATIVO :',
		});	
		var lblaplica_prima = new Ext.form.Label({
			text: '',
			x: 270,
			y: 495,
			height: 20,
			cls: 'namelabel',
			html:'APLICA <br>PRIMA :'
		});
		var lblaplica_planilla_tributaria = new Ext.form.Label({
			text: '',
			x: 10,
			y: 285,
			height: 20,
			cls: 'namelabel',
			html:'APLICA PLANILLA<br>TRIBUTARIA :'
		});
		var lblRegionTrabajo = new Ext.form.Label({
			text: '',
			x: 10,
			y: 135,
			height: 20,
			cls: 'namelabel',
			html:'REGION DE <br>TRABAJO :'
		});	
		var lbltipo_aplica_quincena = new Ext.form.Label({
			text: '',
			x: 270,
			y: 105,
			height: 20,
			cls: 'namelabel',
			html:'TIPO MONTO:'
		});	
		var lblOficina = new Ext.form.Label({
			text: '',
			x: 270,
			y: 135,
			height: 20,
			cls: 'namelabel',
			html:'OFICINA :'

		});	
		var lblmonto_aplica_quincena = new Ext.form.Label({
			text: '',
			x:530,
			y: 105,
			height: 20,
			cls: 'namelabel',
			html:'MONTO :'

		});	
		var lblSueldoBasico = new Ext.form.Label({
			text: 'HABER BASICO:',
			x: 10,
			y: 15,
			height: 20,
			cls: 'namelabel'
		});	
		var lblVariableBase = new Ext.form.Label({
			text: 'VARIABLE BASE:',
			x: 10,
			y: 45,
			height: 20,
			cls: 'namelabel'
		});		
		var lblBonoAntigueda = new Ext.form.Label({
			text: 'BONO ANTIGUEDAD:',
			x: 10,
			y: 45,
			height: 20,
			cls: 'namelabel'
		});	
		var lbltipocontrato = new Ext.form.Label({
			text: 'TIPO CONTRATO :',
			
			x: 530,
			y: 75,
			height: 20,
			cls: 'namelabel'
		});	
		var lblfechaIngre = new Ext.form.Label({
			text: 'FECHA INGRESO :',
			x: 10,
			y: 105,
			height: 20,
			cls: 'namelabel',
		});	
		var lbltel_fijo_lab = new Ext.form.Label({
			text: '',
			x: 765,
			y: 135,
			height: 20,
			cls: 'namelabel',
			html:'TELEFONO FIJO <BR> LABORAL :'
		});	
		
		var lblfechaRetir = new Ext.form.Label({
			text: 'FECHA FINALIZACION :',
			x: 795,
			y: 105,
			height: 20,
			cls: 'namelabel',
			html:'FECHA <BR> FINALIZACION :'
		});	
		var lbldireccion_lab = new Ext.form.Label({
			text: '',
			x:520,
			y: 135,
			height: 20,
			cls: 'namelabel',
			html:'DIRECCION <BR> LABORAL :'
		});	
		var lblinterno = new Ext.form.Label({
			text: '',
			x:950,
			y: 135,
			height: 20,
			cls: 'namelabel',
			html:'INTERNO :'
		});	
		var lblcodigo_dependiente_rc_iva = new Ext.form.Label({
			text: '',
			x: 270,
			y: 285,
			height: 20,
			cls: 'namelabel',
			html:'COD. DEPENDIENTE <BR> RC-IVA :'
		});
		var lblTipoNovedadRC_iva = new Ext.form.Label({
			text: '',
			x: 530,
			y: 285,
			height: 20,
			cls: 'namelabel',
			html:'TIPO DE NOVEDADES <BR> RC-IVA :'
		});		
		var lblmonto_aportes_sindicales1 = new Ext.form.Label({
			text: '',
			x:530,
			y: 375,
			height: 20,
			cls: 'namelabel',
			html:'MONTO :'
		});	
		var lblmonto_aportes_sindicales2 = new Ext.form.Label({
			text: '',
			x:530,
			y: 405,
			height: 20,
			cls: 'namelabel',
			html:'MONTO :'
		});	
		var lblNumeroCuentaBanco = new Ext.form.Label({
			text: '',
			x: 800,
			y: 705,
			height: 20,
			cls: 'namelabel',
			html:'NRO CUENTA BANCO :'
		});
		var lblNUA = new Ext.form.Label({
			text: 'NUA :',
			x: 590,
			y: 345,
			height: 20,
			cls: 'namelabel',
			html:'NUA :'
		});	
		var lblTipoNovedad = new Ext.form.Label({
			text: '',
			x: 10,
			y: 405,
			height: 20,
			cls: 'namelabel',
			html:'TIPO DE <BR>NOVEDAD :'
		});	
		var lblpersona_con_discapacidad = new Ext.form.Label({
			text: '',
			x: 10,
			y: 645,
			height: 20,
			cls: 'namelabel',
			html:'ES PERSONA CON <BR>DISCAPACIDAD :'
		});	
		var lblGerenteArea = new Ext.form.Label({
			text: '',
			x: 530,
			y: 195,
			height: 20,
			cls: 'namelabel',
			html: 'GERENTE DE AREA:',
		});	
		var lblfechabaja = new Ext.form.Label({
			text: '',
			x: 10,
			y: 860,
			height: 20,
			cls: 'namelabel',
			html:'FECHA BAJA :'
		});	
		var lblobservacionbaja = new Ext.form.Label({
			text: '',
			x: 10,
			y: 890,
			height: 20,
			cls: 'namelabel',
			html:'OBSERVACIONES :'
		});	
		var lblfecha_requerimiento = new Ext.form.Label({
			text: '',
			x: 10,
			y: 765,
			height: 20,
			cls: 'namelabel',
			html:'FECHA <br>REQUERIMIENTO :'
		});	
		var lbltipo_alta_requerimiento = new Ext.form.Label({
			text: '',
			x: 285,
			y: 765,
			height: 20,
			cls: 'namelabel',
			html:'TIPO ALTA :'
		});	
		var lblreemplazo = new Ext.form.Label({
			text: '',
			x: 560,
			y: 765,
			height: 20,
			cls: 'namelabel',
			html:'REEMPLAZA A :'
		});
		var lblobservacionrequerimiento = new Ext.form.Label({
			text: '',
			x: 10,
			y: 795,
			height: 20,
			cls: 'namelabel',
			html:'OBSERVACIONES :'
		});	
		var lblPorcentajeRango = new Ext.form.Label({
			text: '% RANGO:',
			x: 500,
			y: 225,
			height: 20,
			cls: 'namelabel'
		});	
		/*var lblNivelJerarquico = new Ext.form.Label({
			text: 'NIVEL JERARQUICO:',
			x: 10,
			y: 225,
			height: 20,
			cls: 'namelabel'
		});	*/
		
		var lblSueldoVariable = new Ext.form.Label({
			text: 'SUELDO VARIABLE:',
			x: 500,
			y: 255,
			height: 20,
			cls: 'namelabel'
		});	
		var lblMinimo = new Ext.form.Label({
			text: 'MINIMO:',
			x: 10,
			y: 285,
			height: 20,
			cls: 'namelabel'
		});	
	
		var lblMidpoint = new Ext.form.Label({
			text: 'MIDPOINT:',
			x: 295,
			y: 285,
			height: 20,
			cls: 'namelabel'
		});	
		var lblMaximo = new Ext.form.Label({
			text: 'MAXIMO:',
			x: 500,
			y: 285,
			height: 20,
			cls: 'namelabel'
		});
	
	
		var lblEvolucionRango = new Ext.form.Label({
			text: 'EVOLUCION DE RANGO:',
			x: 350,
			y: 225,
			height: 20,
			cls: 'x-label'
		});		
		//DEPENDIENTES
		var lblnombre_dependiente = new Ext.form.Label({
			html: 'NOMBRE :',
			x: 10,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblparentesco_dependiente = new Ext.form.Label({
			html: 'PARENTESCO :',
			x: 240,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblci_dependiente = new Ext.form.Label({
			html: 'CI :',
			x: 420,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblfv_dependiente = new Ext.form.Label({
			html: 'FECHA NAC. :',
			x: 555,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var txtNombre_dependiente = new Ext.form.TextField({
			name: 'txtNombre_dependiente',
			maxLength : 30,
			width: 150,
			x: 70,
			y: 15,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			//blankText: 'Campo requerido',
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var storeParentesco_dependiente = new Ext.data.SimpleStore(
			{
				fields: ['codigop', 'nombrep'],
				data : [					
							['1', 'PADRE'],			
							['2', 'MADRE'],
							['3', 'ESPOSO/A'],
							['4', 'HIJO/A'],
							['5', 'HERMANO/A'],
							['6', 'TÍO/A'],
					],   
				autoLoad: false 		
		});	
	
			var cboparentesco_dependiente= new Ext.form.ComboBox(
			{  
				y : 15,
				x: 320,	 				
				width : 80,
				store: storeParentesco_dependiente, 
				mode: 'local',
				//autocomplete : true,
			//	allowBlank: false,
				style : {textTransform: "uppercase"},
				emptyText:'PARENTESCO...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cboparentesco_dependiente',
				//selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
								'select': function(cmb,record,index){
								
								
								}	 
				}		
			});	
			var txtci_dependiente = new Ext.form.TextField({
				name: 'txtci_dependiente',
				maxLength : 30,
				width: 100,
				x: 445,
				y: 15,
				allowBlank: true,
				style : {textTransform: "uppercase"},
				//blankText: 'Campo requerido',
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){
						if(e.getKey()==13){
							
						}
					}
				}
			});
			var txtFechaVenc_dependiente= new Ext.form.DateField({
				name: 'txtFechaVenc_dependiente',
				hideLabel: true, 
				maxLength : 10,
				width: 91,
				y : 15,
				x: 640,		
				format : 'd/m/Y',
				allowBlank: true,		
				enableKeyEvents: true,
				selectOnFocus: true,
				cls:"name",
				listeners: {
					keypress: function(t,e){				
						if(e.getKey()==13){
										
						}
					}
				}				
			});
		var btnAdicionaDependiente = new Ext.Button({
			id: 'btnAdicionaDependiente',
			x: 740,
			y: 15,
			text: '<a style ="color:#15428B; font: bold 10px tahoma,arial,verdana,sans-serif;">Adicionar</a>',
			icon: '../img/Nuevo.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function(){
				
				ActualizarGridDependiente();
				
			} 
		});	
		var registros_dep = new Array(); 
		var registrosb_dep = new Array(); 
		var rowIndex_dep;
		function buscarItemRepetidoDependiente(coditem){ 
			
			var cantida = 0;
			storeDetalleDependiente.each(function(record){
				if(record.data.cip == coditem)
					cantida = 1;
				
			});
			return cantida;
		}
		function ActualizarGridDependiente()
		{				
			dimension = registros_dep.length;
			var registro = new Array(8);
			if(txtNombre_dependiente.getValue()!="" && cboparentesco_dependiente.getValue()!=""  && txtFechaVenc_dependiente.getValue()!=""){
				//if(buscarItemRepetidoDependiente(txtci_dependiente.getValue())==0)
				//{
					registro[0] = txtci_dependiente.getValue().toUpperCase();
					registro[1] = txtNombre_dependiente.getValue().toUpperCase(); 
					registro[2] = cboparentesco_dependiente.getRawValue().toUpperCase(); 
					registro[3] = txtci_dependiente.getValue().toUpperCase(); 
					registro[4] = txtFechaVenc_dependiente.getValue().format('d-m-Y'); 
					registro[5] = cboparentesco_dependiente.getValue();
			
					registros_dep[dimension] = registro;		

					storeDetalleDependiente.loadData(registros_dep);
					txtci_dependiente.setValue("");
					txtNombre_dependiente.setValue("");
					cboparentesco_dependiente.setValue("");
					txtFechaVenc_dependiente.setValue("");
					txtNombre_dependiente.focus(true, 100)
				//}	
				//else
				//{
				//Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">El CI ya fue registrado.</a>'); 
				
				//}
			}
			else
			{
				Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Existen campos obligatorios. Complete los datos para continuar.</a>'); 
				//alert("Elija Un Cargador");
			}
		} 
		function EliminarFila()
		{
			var store = Ext.getCmp("GridDependiente").getStore();
                store.removeAt(rowIndex_dep);				
			this.GridDependiente.getView().refresh();	
			registrosb_dep = null;
			registrosb_dep = new Array();
				for(var i = rowIndex_dep; i < registros_dep.length - 1; i++ )
				{
					registros_dep[i] = registros_dep[i+1];
				}
				
				for(var i = 0; i < registros_dep.length - 1; i++ )
				{
					
					registrosb_dep[i] = registros_dep[i];
				}
				registros=null;
				
				registros_dep = new Array();
				registros_dep = registrosb_dep;
				
				GridDependiente.removeAll();
			    storeDetalleDependiente.removeAll();
				storeDetalleDependiente.loadData(registros_dep);	
			
		} 
		var fm = Ext.form;
		var sm2 = new Ext.grid.CheckboxSelectionModel({
			singleSelect: true,
			listeners: {
				rowselect: function (sm, row, rec) {
					rowIndex_dep = row;
				}, // para cuando deselecciona el check del grid
				rowdeselect: function (sm, row, rec) {
					rowIndex_dep = 'e';
				}
			}
		});
	 	var storeDetalleDependiente = new Ext.data.ArrayStore({// Ext.create('Ext.data.ArrayStore',{  
			fields: [ 
			   {name: 'codigop'},
				{name: 'nombrep'},
				{name: 'parentescop'},
				{name: 'cip'},
				{name: 'fecha_venc_p'},
				{name: 'idparentescop'},
			   
			],  
			id: 0
		});
			
			var Columnas1 = new Ext.grid.ColumnModel(  
			[
				sm2,
				{  
					header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
					dataIndex: '',
					width:25,				
					renderer: function(value, cell){  
						
						str = "<div style='text-align:center;'> <div class='zoom'></div> <img class='zoom' src='../img/Editar.png' WIDTH='13' HEIGHT='13'></div>";    
						return str; 
						
						
						 
					}
				},	
			{  
                header: 'Codigo',  
                dataIndex: 'codigop',                
                hidden: true
            },
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nombre</a>',
                dataIndex: 'nombrep',  
				renderer: formato, 
                width:200,
                sortable: true
			}
			,
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Parentesco</a>',
                dataIndex: 'parentescop',  
				renderer: formato, 
                width:100,
                sortable: true
			},
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">CI</a>',
                dataIndex: 'cip',  
				renderer: formato, 
                width:100,
                sortable: true
			},
			{  
                header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Fecha <br>Nacimiento</a>',
                dataIndex: 'fecha_venc_p',  
				renderer: formato, 
                width:100,
                sortable: true
			}
			
			
			]  
			);
		function formato(value, metadata, record, rowIndex, colIndex, store) {  
			metadata.attr = 'style="font-size:10px;"';    
			 return value; 
		}	
		var GridDependiente = new Ext.grid.EditorGridPanel({  
			id: 'GridDependiente',
			y:45,
			x:15,
			width :700,	
			height : 500,
			
			store: storeDetalleDependiente,				
			cm: Columnas1,
			sm:sm2,
			border: false,   
			enableColLock:false,
			stripeRows: false,
			clicksToEdit: 1,
			listeners:
			{
				'cellclick' : function(grid, rowIndex, cellIndex, e){
					var store = grid.getStore().getAt(rowIndex);
					var columnName = grid.getColumnModel().getDataIndex(cellIndex);
					var cellValue = store.get(columnName);
					
					if(cellIndex==1)
					{
						ActualizarDependiente(rowIndex);
					}
					
					
				}
			}
	
			 
		});			
		var btnQuitar = new Ext.Button({
			id: 'btnQuitar',
			y : 55,
			x: 740,
			text: '<a style ="color:#15428B; font: bold 10px tahoma,arial,verdana,sans-serif;">Quitar</a>',
			
			icon: '../img/delete.png',
			iconCls: 'x-btn-text-icon',
			minWidth: 80,
			handler:function()
			{	
				EliminarFila();
			}
		});	

		//ROPA DE TRABAJO / UNIFORME
		var lblcamisa_uniforme = new Ext.form.Label({
			html: 'CAMISA :',
			x: 10,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblpantalon_uniforme = new Ext.form.Label({
			html: 'PANTALON :',
			x: 10,
			y: 45,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lbloverol_uniforme = new Ext.form.Label({
			html: 'OVEROL :',
			x: 10,
			y: 75,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblotros_uniforme = new Ext.form.Label({
			html: 'OTROS :',
			x: 10,
			y: 105,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblpolera_uniforme = new Ext.form.Label({
			html: 'POLERA :',
			x: 270,
			y: 15,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblchamarra_uniforme = new Ext.form.Label({
			html: 'CHAMARRA :',
			x: 270,
			y: 45,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var lblbotines_uniforme = new Ext.form.Label({
			html: 'BOTINES :',
			x: 270,
			y: 75,
			// x: 10,
			// y: 15,
			height: 20,
			cls: 'namelabel',
			
		});
		var txtcamisa_uniforme = new Ext.form.TextField({
			name: 'txtcamisa_uniforme',
			maxLength : 30,
			width: 150,
			x: 70,
			y: 15,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtpantalon_uniforme = new Ext.form.TextField({
			name: 'txtpantalon_uniforme',
			maxLength : 30,
			width: 150,
			x: 70,
			y: 45,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtoverol_uniforme = new Ext.form.TextField({
			name: 'txtoverol_uniforme',
			maxLength : 30,
			width: 150,
			x: 70,
			y: 75,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtotros_uniforme = new Ext.form.TextField({
			name: 'txtotros_uniforme',
			maxLength : 30,
			width: 435,
			x: 70,
			y: 105,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtpolera_uniforme = new Ext.form.TextField({
			name: 'txtpolera_uniforme',
			maxLength : 30,
			width: 150,
			x: 350,
			y: 15,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtchamarra_uniforme = new Ext.form.TextField({
			name: 'txtchamarra_uniforme',
			maxLength : 30,
			width: 150,
			x: 350,
			y: 45,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtbotines_uniforme = new Ext.form.TextField({
			name: 'txtbotines_uniforme',
			maxLength : 30,
			width: 150,
			x: 350,
			y: 75,
			allowBlank: true,
			style : {textTransform: "uppercase"},
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){
					if(e.getKey()==13){
						
					}
				}
			}
		});
		///parametrosplanilla
		var lblDiasTrabajadosMes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 85,
			height: 20,
			cls: 'namelabel',
			html:'DIAS TRABAJADOS DEL MES :'
		});	
		var lblDomingosDelMes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 115,
			height: 20,
			cls: 'namelabel',
			html:'DOMINGOS DEL MES :'
		});	
		var lblHorasExtDelMes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 145,
			height: 20,
			cls: 'namelabel',
			html:'HORAS EXTRAS DEL MES :'
		});	
		var lblHorasExtrasFeriadosMes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 175,
			height: 20,
			cls: 'namelabel',
			html:'HORAS EXTRAS FERIADO DEL MES :'
		});	
		var lblHorasExtrasDomingosMes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 205,
			height: 20,
			cls: 'namelabel',
			html:'HORAS EXTRAS DOMINGOS DEL MES :'
		});	
		var lblRNMes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 235,
			height: 20,
			cls: 'namelabel',
			html:'RECARGO NOCTURNO DEL MES :'
		});	

		var lblComision_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 265,
			height: 20,
			cls: 'namelabel',
			html:'COMISIONES :'
		});	
		var lblOtrosIngresos_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 295,
			height: 20,
			cls: 'namelabel',
			html:'OTROS INGRESOS :'
		});	
		var lblOtrosIngresos2_mes = new Ext.form.Label({
			text: '',
			x: 800,
			y: 295,
			height: 20,
			cls: 'namelabel',
			html:'OTROS INGRESOS 2:'
		});	
		var lblOtrosegresos1_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 325,
			height: 20,
			cls: 'namelabel',
			html:'OTROS EGRESOS :'
		});	
		var lblOtrosegresos2_mes = new Ext.form.Label({
			text: '',
			x: 800,
			y: 325,
			height: 20,
			cls: 'namelabel',
			html:'CREDITO FARMACIA:'
		});	
		
		var lblOtrosEgresos_mes = new Ext.form.Label({
			text: '',
			x: 800,
			y: 415,
			height: 20,
			cls: 'namelabel',
			html:'TOTAL <br>OTROS EGRESOS :'
		});	
		//nuevos campos
		var lblprestamo_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 355,
			height: 20,
			cls: 'namelabel',
			html:'PRESTAMO :'
		});	
		var lblseguro_privado_mes = new Ext.form.Label({
			text: '',
			x: 800,
			y: 355,
			height: 20,
			cls: 'namelabel',
			html:'SEGURO PRIVADO :'
		});	
		//nuevos campos
		var lblpulperia_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 385,
			height: 20,
			cls: 'namelabel',
			html:'PULPERIA :'
		});	
		var lblcolaboraciones_mes = new Ext.form.Label({
			text: '',
			x: 800,
			y: 385,
			height: 20,
			cls: 'namelabel',
			html:'COLABORACIONES :'
		});	
		////////////////////////
		var lblretencion_judicial_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 415,
			height: 20,
			cls: 'namelabel',
			html:'RETENCION JUDICIAL :'
		});	
		var lblrc_ivaf110_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 445,
			height: 20,
			cls: 'namelabel',
			html:'RC-IVA F110 :'
		});
		var lblotros_ingesos_adicionales = new Ext.form.Label({
			text: '',
			x: 450,
			y: 475,
			height: 20,
			cls: 'namelabel',
			html:'OTROS INGRESOS ADICIONALES PARA<br> PLANILLA IMPOSITIVA :'
		});	
		var lblbono_produccion = new Ext.form.Label({
			text: '',
			x: 800,
			y: 475,
			height: 20,
			cls: 'namelabel',
			html:'BONO<br> PRODUCCIÓN :'
		});
		var lblhaber_basico_promocion_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 490,
			height: 20,
			cls: 'namelabel',
			html:'HABER BASICO :'
		});	

		var lbldias_trabajados_promocion_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 520,
			height: 20,
			cls: 'namelabel',
			html:'DIAS TRABAJADOS DEL MES :'
		});	
		var lblcargo_promocion_mes = new Ext.form.Label({
			text: '',
			x: 450,
			y: 550,
			height: 20,
			cls: 'namelabel',
			html:'CARGO :'
		});	
		
		var txtDiasTrabajadosMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtDiasTrabajadosMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 85,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		
		var txtDomingosMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtDomingosMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 115,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtHEMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtHEMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 145,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtHEFMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtHEFMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 175,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtHEDMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtHEDMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 205,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtRNMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtRNMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 235,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});

		var txtComisionMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtComisionMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 265,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtOtrosIngresosMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtOtrosIngresosMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 295,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		
		var txtOtrosIngresosMes2 = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtOtrosIngresosMes2',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 920,
			y: 295,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		
		var txtOtrosEgresosMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			readOnly:true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtOtrosEgresosMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 920,
			y: 415,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtOtrosEgresosMes2 = new Ext.form.NumberField({//esto queda desahibilitado por nuevos egresos
			allowDecimals: true,
			hidden:true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtOtrosEgresosMes2',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 920,
			y: 325,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});

		//campos nuevos
		function calTotal(cad1, cad2, cad3, cad4, cad5, cad6, cad7) {
		
			var v1 = cad1;
			
			var v2 = cad2;
		
			var v3 = cad3;
			
			var v4 = cad4;
			
			var v5 = cad5;

			var v6 = cad6;

			var v7 = cad7;
			
			vtotal=parseFloat(v1)+parseFloat(v2)+parseFloat(v3)+parseFloat(v4)+parseFloat(v5)+parseFloat(v6)+parseFloat(v7);
			
		//    console.log("v1: "+v1+"; v2: "+v2);
			return vtotal;
		}
		var txtOtrosegresos1Mes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtOtrosegresos1Mes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 325,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				'keyup': function () {

					v1=txtOtrosegresos1Mes.getValue();
					v2=txtOtrosegresos2Mes.getValue();
					v3=txtprestamoMes.getValue();
					v4=txtseguro_privado_mes.getValue();
					v5=txtretencionJudicialMes.getValue();

					v6=txtpulperiaMes.getValue();
					v7=txtcolaboracion_mes.getValue();

					if(v1==''){v1=0;}
					if(v2==''){v2=0;}
					if(v3==''){v3=0;}
					if(v4==''){v4=0;}
					if(v5==''){v5=0;}
					if(v6==''){v6=0;}
					if(v7==''){v7=0;}
					vtotal=calTotal(v1,v2,v3,v4,v5,v6,v7);
					txtOtrosEgresosMes.setValue(vtotal);
					
				}
			}
		});
		var txtOtrosegresos2Mes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtOtrosegresos2Mes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 920,
			y: 325,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				'keyup': function () {

					v1=txtOtrosegresos1Mes.getValue();
					v2=txtOtrosegresos2Mes.getValue();
					v3=txtprestamoMes.getValue();
					v4=txtseguro_privado_mes.getValue();
					v5=txtretencionJudicialMes.getValue();

					v6=txtpulperiaMes.getValue();
					v7=txtcolaboracion_mes.getValue();
					
					if(v1==''){v1=0;}
					if(v2==''){v2=0;}
					if(v3==''){v3=0;}
					if(v4==''){v4=0;}
					if(v5==''){v5=0;}
					if(v6==''){v6=0;}
					if(v7==''){v7=0;}
					vtotal=calTotal(v1,v2,v3,v4,v5,v6,v7);
					txtOtrosEgresosMes.setValue(vtotal);
					
				}
			}
		});
		var txtprestamoMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtprestamoMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 355,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				'keyup': function () {

					v1=txtOtrosegresos1Mes.getValue();
					v2=txtOtrosegresos2Mes.getValue();
					v3=txtprestamoMes.getValue();
					v4=txtseguro_privado_mes.getValue();
					v5=txtretencionJudicialMes.getValue();
					v6=txtpulperiaMes.getValue();
					v7=txtcolaboracion_mes.getValue();
					if(v1==''){v1=0;}
					if(v2==''){v2=0;}
					if(v3==''){v3=0;}
					if(v4==''){v4=0;}
					if(v5==''){v5=0;}
					if(v6==''){v6=0;}
					if(v7==''){v7=0;}
					vtotal=calTotal(v1,v2,v3,v4,v5,v6,v7);
					txtOtrosEgresosMes.setValue(vtotal);
					
				}
			}
		});
		var txtseguro_privado_mes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtseguro_privado_mes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 920,
			y: 355,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				'keyup': function () {
					v1=txtOtrosegresos1Mes.getValue();
					v2=txtOtrosegresos2Mes.getValue();
					v3=txtprestamoMes.getValue();
					v4=txtseguro_privado_mes.getValue();
					v5=txtretencionJudicialMes.getValue();
					v6=txtpulperiaMes.getValue();
					v7=txtcolaboracion_mes.getValue();
					if(v1==''){v1=0;}
					if(v2==''){v2=0;}
					if(v3==''){v3=0;}
					if(v4==''){v4=0;}
					if(v5==''){v5=0;}
					if(v6==''){v6=0;}
					if(v7==''){v7=0;}
					vtotal=calTotal(v1,v2,v3,v4,v5,v6,v7);
					txtOtrosEgresosMes.setValue(vtotal);
					
				}
			}
		});
		////////////Nuevos Campos
		var txtpulperiaMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtpulperiaMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 385,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				'keyup': function () {
					v1=txtOtrosegresos1Mes.getValue();
					v2=txtOtrosegresos2Mes.getValue();
					v3=txtprestamoMes.getValue();
					v4=txtseguro_privado_mes.getValue();
					v5=txtretencionJudicialMes.getValue();
					v6=txtpulperiaMes.getValue();
					v7=txtcolaboracion_mes.getValue();
					if(v1==''){v1=0;}
					if(v2==''){v2=0;}
					if(v3==''){v3=0;}
					if(v4==''){v4=0;}
					if(v5==''){v5=0;}
					if(v6==''){v6=0;}
					if(v7==''){v7=0;}
					vtotal=calTotal(v1,v2,v3,v4,v5,v6,v7);
					txtOtrosEgresosMes.setValue(vtotal);
				}
			}
			});
		var txtcolaboracion_mes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtcolaboracion_mes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 920,
			y: 385,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				'keyup': function () {
					v1=txtOtrosegresos1Mes.getValue();
					v2=txtOtrosegresos2Mes.getValue();
					v3=txtprestamoMes.getValue();
					v4=txtseguro_privado_mes.getValue();
					v5=txtretencionJudicialMes.getValue();
					v6=txtpulperiaMes.getValue();
					v7=txtcolaboracion_mes.getValue();
					if(v1==''){v1=0;}
					if(v2==''){v2=0;}
					if(v3==''){v3=0;}
					if(v4==''){v4=0;}
					if(v5==''){v5=0;}
					if(v6==''){v6=0;}
					if(v7==''){v7=0;}
					vtotal=calTotal(v1,v2,v3,v4,v5,v6,v7);
					txtOtrosEgresosMes.setValue(vtotal);
					
				}
			}
		});
		/////////////////////////////////////
		var txtretencionJudicialMes = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtretencionJudicialMes',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 415,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				'keyup': function () {
					v1=txtOtrosegresos1Mes.getValue();
					v2=txtOtrosegresos2Mes.getValue();
					v3=txtprestamoMes.getValue();
					v4=txtseguro_privado_mes.getValue();
					v5=txtretencionJudicialMes.getValue();
					v6=txtpulperiaMes.getValue();
					v7=txtcolaboracion_mes.getValue();
					if(v1==''){v1=0;}
					if(v2==''){v2=0;}
					if(v3==''){v3=0;}
					if(v4==''){v4=0;}
					if(v5==''){v5=0;}
					if(v6==''){v6=0;}
					if(v7==''){v7=0;}
					vtotal=calTotal(v1,v2,v3,v4,v5,v6,v7);
					txtOtrosEgresosMes.setValue(vtotal);
				}
			}
		});
       
		var txtrc_iva_f110 = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtrc_iva_f110',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 445,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtotros_ing_adicionales_planillaimpo = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtotros_ing_adicionales_planillaimpo',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 475,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtbono_produccion = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtbono_produccion',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 920,
			y: 475,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txt_saldo_dependiente_periodo_anterior = new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txt_saldo_dependiente_periodo_anterior',
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 385,
			width: 150,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"name",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		//////////////////nuevo cargo/haber basico/promociones
		var txthaberBasicoPromocion= new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txthaberBasicoPromocion',
			hidden:true,
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 490,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var txtDiasDeTrabajoPromocion= new Ext.form.NumberField({
			allowDecimals: true,
			allowBlank: true,
			decimalPrecision :2,
			allowNegative: false,
			name: 'txtDiasDeTrabajoPromocion',
			hidden:true,
			hideLabel: true,		
			maxLength : 20,	
			align: 'right',
			forceDecimalPrecision : true,
			x: 650,
			y: 520,
			width: 100,
			value : 0,
			style: 'text-align: right',		
			enableKeyEvents: true,
			selectOnFocus: true,
			cls:"numero",
			listeners: {
				keypress: function(t,e){				
					if(e.getKey()==13){
						
					}
				}
			}
		});
		var storecargopromocion= new Ext.data.JsonStore(
			{   
				url:'../servicesAjax/DSListaCargoCBAjax.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep']			
			});		
			storecargopromocion.load();
	
			var cboCargoPromocion= new Ext.form.ComboBox(
			{   		
				x: 650,
				y: 550,			
				width : 285,
				store: storecargopromocion, 
				mode: 'local',
				hidden:true,
				//autocomplete : true,
				allowBlank: true,
				style : {textTransform: "uppercase"},
				emptyText:'Seleccione CARGO...',   
				triggerAction: 'all',   		
				displayField:'nombrep',   
				//typeAhead: true,
				valueField: 'codigop',
				hiddenName : 'cboCargoPromocion',
				//selectOnFocus: true,
				forceSelection:true,
				cls: 'name',
				listeners: {
							  
				}		
				});	
		////previsualizacion
		var storePrevisualizacion = new Ext.data.JsonStore(
			{
					url: '../servicesAjax/DSListadoPrevisualizacion.php',
					root: 'data',			
					totalProperty: 'total',
					fields: ['id', 'nombre','monto','descripcion'],
					listeners: { 
						 load: function(thisStore, record, ids) { 
											
								
						}
	
					}	      
				
						
			});
			
			var ColumnasPrev = new Ext.grid.ColumnModel(  
			[
				{  
					header: 'Codigo',  
					dataIndex: 'id', 			
					width : 100,
					hidden: true
				}
				,{  
					header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>',
					dataIndex: 'nombre',  		
					width : 360
				},{  
					header: '<a style ="font: bold 11px tahoma,arial,verdana,sans-serif;">MONTO</a>', 
					dataIndex: 'monto', 
					align:'right', 		
					width : 130
				},{  
					header: '<a style ="font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
					dataIndex: 'descripcion', 
					align:'left', 		
					width : 130
				}
					
			]  
			);
			var gridPrev = new Ext.grid.EditorGridPanel({  
				id: 'gridPrev',			
				height:600,
				width : 750,
				x: 10,
				y: 10,
				store: storePrevisualizacion,	
				autoScroll:true,			
				cm: ColumnasPrev, 			
				border: false,   
				enableColLock:false,
				stripeRows: false,				
				deferRowRender: false,
				
				destroy : function () {
					if (this.store) {
						this.store.destroyStore();
					}
					this.callParent();
				},
			});

			////CAMBIOS CONTRACTUALES
			var storeCambioContractual = new Ext.data.JsonStore(
				{
						url: '../servicesAjax/DSListadoCambiosContractualPersonalAjax.php',
						root: 'data',			
						totalProperty: 'total',
						fields: ["codigo", "mes_reporte", "cod_trabajador","nombre", "cargo", "unidad", "division", "centro_costo", "sucursal",
						"tipocontrato","clasificacion", "haberbasico", "porc_dif_hb", "variable_base", "porc_dif_base" ],	
						listeners: { 
							 load: function(thisStore, record, ids) { 
												
									
							}
		
						}	      
					
							
				});
				
				var ColumnasCC = new Ext.grid.ColumnModel(  
					[
						new Ext.grid.RowNumberer({width: 23,locked: true}),
						{  
							header: 'Codigo',  
							dataIndex: 'codigo',                
							hidden: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Mes Reporte</a>', 
							dataIndex: 'mes_reporte',  
							renderer: formato, 
						   width:70,
						   align: 'center',
						   sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Código</a>', 
							dataIndex: 'cod_trabajador',  
							renderer: formato, 
						   width:50,
						   align: 'center',
						   sortable: true
						},
						{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Nombre del Trabajador</a>',   
							dataIndex: 'nombre',  
							renderer: formato, 
							width:250,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Cargo</a>',
							dataIndex: 'cargo', 
							renderer: formato, 				
							width: 200,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Unidad</a>',
							dataIndex: 'unidad', 
							renderer: formato, 				
							width: 100,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Division</a>',
							dataIndex: 'division', 
							renderer: formato, 				
							width: 100,
							sortable: true
						},{  
							header:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Centro</a>',
							dataIndex: 'centro_costo', 
							renderer: formato, 
							width: 140,
							sortable: true
						},{  
							header:  '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Sucursal</a>',
							dataIndex: 'sucursal', 
							renderer: formato, 
							width: 90,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Tipo de Contrato</a>',
							dataIndex: 'tipocontrato', 
							renderer: formato, 				
							width: 130,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Clasificación</a>',
							dataIndex: 'clasificacion', 
							renderer: formato, 				
							width: 80,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Haber Basico</a>',
							dataIndex: 'haberbasico', 
							renderer: formato, 				
							width: 80,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">% Diferencia</a>',
							dataIndex: 'porc_dif_hb', 
							renderer: formato, 				
							width: 80,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Variable Base</a>',
							dataIndex: 'variable_base', 
							renderer: formato, 				
							width: 80,
							sortable: true
						},{  
							header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">% Diferencia</a>',
							dataIndex: 'porc_dif_base', 
							renderer: formato, 				
							width: 80,
							sortable: true
						}		
						
					]  
				);	
				var gridCambioContractual = new Ext.grid.EditorGridPanel({  
					id: 'gridCambioContractual',			
					height:600,
					width : 1520,
					x: 10,
					y: 10,
					store: storeCambioContractual,	
					autoScroll:true,			
					cm: ColumnasCC, 			
					border: false,   
					enableColLock:false,
					stripeRows: false,				
					deferRowRender: false,					
					destroy : function () {
						if (this.store) {
							this.store.destroyStore();
						}
						this.callParent();
					},	tbar: [
						{  	
						
							text: 'descargar',
							icon: '../img/excel.png',
							handler: function confirm()
							{		
																
								 location = "../servicesAjax/DSExcelReporteHistoricoCambioContractuales.php?codigo="+codigo;  
							}
						}
					]
				});
	
	

		////planilla impositiva
		var storePlanillaImpositiva = new Ext.data.JsonStore(
			{
					url: '../servicesAjax/DSListadoPrevisualizacionPI.php',
					root: 'data',			
					totalProperty: 'total',
					fields: ['id', 'nombre','descripcion'],
					listeners: { 
						 load: function(thisStore, record, ids) { 
							
							
								
						}
	
					}	      
				
						
			});
			
			var ColumnasPI = new Ext.grid.ColumnModel(  
			[
				{  
					header: 'Codigo',  
					dataIndex: 'id', 			
					width : 100,
					hidden: true
				}
				,{  
					header: '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;"></a>',
					dataIndex: 'nombre',  		
					width : 520
				},{  
					header: '<a style ="font: bold 11px tahoma,arial,verdana,sans-serif;"></a>', 
					dataIndex: 'descripcion', 
					align:'left', 		
					width : 200
				}
					
			]  
			);
			var gridPI = new Ext.grid.EditorGridPanel({  
				id: 'gridPI',			
				height:650,
				width : 750,
				x: 10,
				y: 10,
				store: storePlanillaImpositiva,	
				autoScroll:true,			
				cm: ColumnasPI, 			
				border: false,   
				enableColLock:false,
				stripeRows: false,				
				deferRowRender: false,
				
				destroy : function () {
					if (this.store) {
						this.store.destroyStore();
					}
					this.callParent();
				},
			});
		//movil
		function ActualizarCelularValido(idpersona,celular,nro_trabajador,nombre_trabajador,activo_f,op,cargo,unidad,subcentro,centro)
		{

				Ext.Ajax.request({
				
				// url:'https://solucionesintecruz.com.bo/biometrico/apirest/celular.php',
				url:'https://solucionesintecruz.com.bo/biometrico',
				method:'POST',
				method:'POST',
				cors: true,
   				useDefaultXhrHeader : false,
				params:{idpersona:idpersona,celular:celular,nro_trabajador:nro_trabajador,nombre_trabajador:nombre_trabajador,activo_f:activo_f,op:op,cargo:cargo,unidad:unidad,subcentro:subcentro,centro:centro},
				success:desactivo,
				failures:no_desactivo
				});
			
				function desactivo(resp)
				{
					

				}
				function no_desactivo(resp)
				{
					
				}
		}
		var PAmenu = new Ext.FormPanel(
		{
			labelAlign: 'top',			
			bodyStyle:'padding:5px',
			fileUpload: true,
			items: [
					{
					xtype:'tabpanel',
					activeTab: 0,
					id:'main-tabs',
					height: 960,
					resizable:true,
					//autoScroll:true,
					//deferredRender: false,
					defaults:{bodyStyle:'padding:10px'},
					items:[{
						    title:'DATOS PERSONALES',
						    layout:'absolute',
							id: 't1',
						    frame:true,
						  items: [lblNombre,lblNombre2,lblNombre3,lblapp,lblapm,lblapcasada,lbltipoDocumento,lblci,lblextension,lblfvencimientodoc,lblcomplemento,
								lblNacionalidad,lblPais,lblFecha,lblTipoSangre,lblgenero,lblnivelinstruccion, lblprofesion_oficio,lblcorreo_personal,
								lbllugardomicilio,lblZona,
								lbldirecciondomicilio,lblTelefono1,lblTelefono2,lblCelular1,lblCelular2,lblEstadoCivil,
								lblNroLicencia,lbltipoLicencia,lblfecha_venc_lic,lblNombre_contacto,lbltel_contacto,lbldir_contacto,
								txtNombre,txtSegNombre,txtTerNombre,txtapp, txtapm,txtapcasada,cboTipoDocumento, txtci,cboExtension,txtFVencDoc,txtcomplemento,
								txtnacionalidad,cboNacionalidad,cboGenero,cboNivelInstruccion,txtprofesion,txtpais_nacimiento,txtciudad_nacimiento,
								txtprovincia_nacimiento,cboPais,cboCiudad,cboProvincia,txtFechaNacimiento,cboTipoSangre,cboEstadoCivil,
								txtpais_domicilio,
								txtciudad_domicilio,txtprovincia_domicilio,cboPaisDomicilio,cboCiudadDomicilio,cboProvinciaDomicilio,
								txtZona,txtDireccionDomicilio,txtTelefono1,txtTelefono2,txtcelular1,txtcelular2,txtCorreoPersonal,
								txtnro_lic,txttipo_lic,txtfecha_venc_lic,txtcontacto_emergencia,txttel_contacto,txtdir_contacto,
								chkactive,fichero_perfil,gridfoto]
						   },  
						   {
						    title:'DATOS LABORALES',
						    layout:'absolute',
							id: 't2',
						    frame:true,
						     // items: [lblunidad,lblsubcentro,lblcentro,lblcargo,lbltipoTrabjador,lbltipocontrato,lblRegionTrabajo,lblOficina,lblNivelJerarquico,lblSueldoBasico,lblSueldoVariable,lblMinimo,lblMidpoint,lblMaximo,lblPorcentajeRango,lblEvolucionRango,lbljefeDirecto,lblJefeArea,lblGerenteArea,
					// cboUnidad,cboSubCentro,cboCentro,cboCargo,cboTipoTrabajador,cboTipoContrato,cboRegionalTrabajo,cboOficina,cboNivelJerarquico,cboJefeDirecto,cboJefeArea,cboGerenteArea,
					// txtSueldoBasico,txtSueldoVariable,txtMinimo,txtMidPoint,txtMaximo,txtPorcentajeRango,txtEvolucionRango]
							items: [
								txtSueldoVariable,txtMinimo,txtMidPoint,txtMaximo,txtEvolucionRango,
								RBvAplicaAportesSindicales1,RBvtipoAportesSindicales1,txtmonto_aportes_sindicales1,
								RBvAplicaAportesSindicales2,RBvtipoAportesSindicales2,txtmonto_aportes_sindicales2,
								lblNroTrabajador,lblplanilla,lblaplica_retencion_impositiva,lblunidad,lblsubcentro,lblcentro,
								lblJefeDirecto,lblJefeArea,lblGerenteArea,
								lblRegionTrabajo,lblOficina,lblTipoEvaluacion,lblNivelJerarquico,
								lblCelularCorporativo,lblCorreoCorporativo,
								lblcargo,lbltipoTrabjador,lblmodalidad_trabajo,lblclasificacion_laboral,lblmodalidad_contrato,
								lbltipocontrato,lblfechaIngre,lblfechaRetir,lbltel_fijo_lab,lbldireccion_lab,lblinterno,
								lblfechaParaVacacionesEspeciales,lblfechaParaBonoAntiguedad,
								lblsindicalizado,
								lblaplica_planilla_tributaria,lblcodigo_dependiente_rc_iva,lblTipoNovedadRC_iva,
								lblaplica_afp,lblAFP,lblNUA,lblNROASEGURADO,
								lblTIPO_APORTE_AFP,lblEstaJubilado,lblaporta_afp,
								lblTipoNovedad,lblfecha_novedad,lbltipo_asegurado,
								lblaplica_aportes_patronales,
								lblaplica_aguinaldo,lblaplica_prima,lblaplica_indemnizacion,lblindemnizacion_pagada_hast,
								lblaplica_aguinaldo2,lblplanta_costeo,
								lblaplica_retroactivo,lblproceso_costeo,
								lblaplica_infocal,lbltipo_costo,
								lblpersona_con_discapacidad,lblEsTutotDePersonaDiscapacidad,
								lblforma_pago,lblBancoParaSueldos,lbltipo_de_cuenta,lblNumeroCuentaBanco,
								lblfechabaja,lblmotivo_baja,lblobservacionbaja,lblobservacionrequerimiento,
								lblfecha_requerimiento,lbltipo_alta_requerimiento,lblreemplazo,
								lblenun1,lblenun2,lblenun3,lblenun4,lblenun5,lblenun6,lblenun8,lblenun9,
								txtNroTrabajador,cboPlanilla,RBvAplica_retencion_imp,cboUnidad,cboSubCentro,cboCentro,
								cboCargo,cboTipoTrabajador,cboTipoContrato,cboTipoContrato_modo,cboModalidadTrabajo,
								txtFechaIngreso,txtFechaParaVacionesEspeciales,txtFechaParaBonoAntiguedad,txtFechaFin,
								cboRegionalTrabajo,cboOficina,txtdireccionLaboral,txtTelefonoFijoLaboral,txtInterno,
								cboclasificacion_laboral,RBvSindicalizado,
								cboJefeDirecto,cboJefeArea,cboGerenteArea,
								txtcelularCorporativo,txtCorreoCorporativo,cboTipoEvaluacion,cboNivelJerarquico,
								RBvAplicaPlanillaTributaria,txtcodigo_dependiente_rc_iva,cbotipo_novedad_rc_iva,
								RBvAplica_afp,cboAFP,txtNUA,txtNumeroAsegurado,
								cboTIPOAFP,RBvEstaJubilado,RBvAporta_a_la_afp,
								cboTipoNovedad,txtFechaNovedad,cboTipoAsegurado,
								RBvAplicaAportesPatronales,
								RBvAplicaAguinaldo,RBvAplicaPrima,RBvAplicaIndemnizacion,txtFechaIndemnizacion,
								RBvAplicaAguinaldo2,
								RBvAplicaRetroactivo,
								RBvAplicaInfocal,cbofuente_min_eco,cboorganismo_min_eco,
								RBvEsPersonaConDiscapacidad,RBvEsTutorDePersonaConDisc,
								txtPlanta_Costeo,txtProceso_Costeo,txttipo_Costeo,
								cboforma_pago,txtBancoParaElAbono,cbotipo_cuenta,txtNroCuentaBanco,
								
								txtFechaRequerimiento,cbotipo_alta,txtReemplaza_requerimiento,
								txtObservacion_requerimiento,
								txtFechaBaja,cbomotivo_retiro,txtObservacion_baja,
								
								txtFechaCertificadoPTJ
								
							]
								
						   },
						   {
						    title:'REMUNERACION',
						    layout:'absolute',
							id: 't5',
						    frame:true,
						   items: [RBvAplicaQuincena,RBvtipopagoAplicaQuincena,txtmonto_aplica_quincena,
							   lblSueldoBasico,lbldominical,
							   lblVariableBase,lbltipodeVariable,
							   lblDiasTrabajadosMes,lblDomingosDelMes,lblHorasExtDelMes,lblHorasExtrasFeriadosMes,
							   lblHorasExtrasDomingosMes,lblRNMes,lblComision_mes,lblOtrosIngresos_mes,lblOtrosIngresos2_mes,lblOtrosEgresos_mes,
							   lblOtrosegresos1_mes,lblOtrosegresos2_mes,
							   lblprestamo_mes,lblseguro_privado_mes,
							   lblpulperia_mes,lblcolaboraciones_mes,
							   lblretencion_judicial_mes,lblrc_ivaf110_mes,lblotros_ingesos_adicionales,lblbono_produccion,
							        //lblaplica_quincena,
									//lbltipo_aplica_quincena,
									//lblmonto_aplica_quincena,
									txtSueldoBasico,cboDominical,chkbonoAntiguedadDif,cboBonoAntiguedad,RBvBonoAntiguedad,
									txtVariableBase,cboTipoVariable,
									
									gridConceptos,
									txtDiasTrabajadosMes,txtDomingosMes,txtHEMes,txtHEFMes,txtHEDMes,txtRNMes,txtComisionMes,
									txtOtrosIngresosMes,txtOtrosIngresosMes2,txtOtrosEgresosMes2,
									txtOtrosegresos1Mes,txtOtrosegresos2Mes,
									txtprestamoMes,txtseguro_privado_mes,
									txtpulperiaMes,txtcolaboracion_mes,
									txtretencionJudicialMes,txtOtrosEgresosMes,
									txtrc_iva_f110,txtotros_ing_adicionales_planillaimpo,txtbono_produccion,
									
									txthaberBasicoPromocion,txtDiasDeTrabajoPromocion,cboCargoPromocion
									
								]
						   },
						   {
						    title:'SIMULADOR',
						    layout:'absolute',
							id: 't6',
						    frame:true,
						   items: [
									gridPrev
							]
						   },
						   {
						    title:'PLANILLA IMPOSITIVA',
						    layout:'absolute',
							id: 't7',
						    frame:true,
						   items: [
									gridPI
							]
						   },
						   {
						    title:'DEPENDIENTES',
						    layout:'absolute',
							id: 't3',
						    frame:true,
						   items: [lblnombre_dependiente,lblparentesco_dependiente,lblci_dependiente,lblfv_dependiente,
									txtNombre_dependiente,cboparentesco_dependiente,txtci_dependiente,txtFechaVenc_dependiente,btnAdicionaDependiente,
									GridDependiente,btnQuitar
									]
						   },
						   {
						    title:'ROPA DE TRABAJO / UNIFORME',
						    layout:'absolute',
							id: 't4',
						    frame:true,
						   items: [lblcamisa_uniforme,lblpolera_uniforme,
									lblpantalon_uniforme,lblchamarra_uniforme,
									lbloverol_uniforme,lblbotines_uniforme,
									lblotros_uniforme,
									txtcamisa_uniforme,txtpolera_uniforme,
									txtpantalon_uniforme,txtchamarra_uniforme,
									txtoverol_uniforme,txtbotines_uniforme,
									txtotros_uniforme
									]
						   },{
						    title:'HISTORICO CAMBIOS CONTRACTUALES',
						    layout:'absolute',
							id: 't8',
						    frame:true,
						   items: [
								gridCambioContractual
							]
						   }
						   ],

						   listeners: {
							'tabchange': function(tabPanel, tab){
								txtSueldoBasico.focus(true, 300);	
								storePrevisualizacion.load({params:{codigo: codigo}});
								storePlanillaImpositiva.load({params:{codigo: codigo}});
								debugger;
								storeCambioContractual.load({params:{codigo: codigo}});
								
							}
						}
					}
																					
				],
				guardarDatos: function(){				
				if (this.getForm().isValid()) {
					this.getForm().submit({
						url: '../servicesAjax/DSabmpersonalAJAX.php',	
						params :{codigo: codigo, opcion: opcion,cboPais:cboPais.getRawValue(),
							cboCiudad:cboCiudad.getRawValue(),cboProvincia:cboProvincia.getRawValue(),
							paisdomi:cboPaisDomicilio.getRawValue(),ciuddomi:cboCiudadDomicilio.getRawValue(),
							prodomicilio:cboProvinciaDomicilio.getRawValue(),active:active,
							registrosGrid_m:registrosGrid_m,registrosGrid_conceptos:registrosGrid_conceptos,
							bono_antiguedad_dif_check:bono_antiguedad_dif_check,foto:foto},	
						method: 'POST',
						waitTitle: 'Conectando',
						waitMsg: 'Enviando datos...',
						success: function(form, action){
							var data = Ext.util.JSON.decode(action.response.responseText);
								cod = data.message.reason;
								var frm = PAmenu.getForm();
								//txtNombre,txtSegNombre,txtapp, txtapm
								var chx = Ext.getCmp('active');
								var acti=0;
								if(chx.getValue()==true)
								{
									acti=1;
								}
								ActualizarCelularValido(cod,txtcelular2.getValue(),txtNroTrabajador.getValue(),txtNombre.getValue()+" "+txtapp.getValue(),acti,opcion,cboCargo.getRawValue(),cboUnidad.getRawValue(),cboSubCentro.getRawValue(),cboCentro.getRawValue())
								frm.reset();
								frm.clearInvalid();
								windatosPersonal.hide();
								aux=0;
								aux1=0;
								Ext.dsdata.storedatospersonal.load({params:{start:0,limit:250}});
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
				else
				{
					var tabPanel = Ext.getCmp("main-tabs");
							  tabPanel.show();
							 tabPanel.setActiveTab("t1");
					if(cboTipoContrato.getValue()==1)		 
					txtFechaFin.setDisabled(true);
					Ext.MessageBox.alert('Mensaje', '<a style ="color:#15428B; font: bold 11px tahoma,arial,verdana,sans-serif;">Algunos campos son obligatorios</a>'); 
				}
				},
				guardarFoto: function(){				
					this.getForm().submit({
					url: '../servicesAjax/DSsubirFotoAJAX.php',	
					params :{codigo: codigo, opcion: opcion,randonfoto:randonfoto},	
					method: 'POST',
					waitTitle: 'Conectando',
					waitMsg: 'Enviando datos...',
					success: function(form, action){
						var data = Ext.util.JSON.decode(action.response.responseText);
						foto = data.message.reason;
						ActualizarGrid(foto);	
					},
					failure: function(form, action){
						if (action.failureType == 'server') {
							var data = Ext.util.JSON.decode(action.response.responseText);
							Ext.Msg.alert('ERROR', data.errors.reason, function(){
								txtDescripcion.focus(true, 100);
							});
						}
						else {
							Ext.Msg.alert('Error!', 'Imposible conectar con servidor : ' + action.response.responseText);
						}					
					}
				});
				
			
			 }
			});
			
		var PAmenuEmpleadoG = new Ext.Panel(
		{
			region: 'north',
			id: 'PAcabeceraGuardar1',
			height: 29, 
			width: 1100,			
			tbar: [btnAceptarPersonal,btnLimpiarPersonal]
		})
        function Altapersonal(val_form){
			bandera=0;	
			
        	cboCiudad.enable(false);
			  cboProvincia.enable(false);
			   cboCiudadDomicilio.enable(false);
			  cboProvinciaDomicilio.enable(false);
			
				windatosPersonal = new Ext.Window({
					layout: 'form',
					width: 880,
					height: 750,
					y:0,		
					title: 'PERSONAL',			
					resizable: true,
					closeAction: 'hide',
					closable: true,
					draggable: false,
					plain: true,
					border: false,	
					modal: true,
					autoScroll:true,
					//maximizable: true,
					maximized: true,
					items: [PAmenuEmpleadoG,PAmenu],
					listeners: {				
						show: function(){
							var tabPanel = Ext.getCmp("main-tabs");
								  tabPanel.setActiveTab("t2");
								  tabPanel.setActiveTab("t5");
								  tabPanel.setActiveTab("t3");
								  tabPanel.setActiveTab("t4");
								 tabPanel.setActiveTab("t1");
							console.log(Ext.getCmp("t5"));
							console.log(tabPanel.items.items);
							  // tabPanel.show();
							  if(val_form == 'registroAltas'){
								 tabPanel.hideTabStripItem(2);
								 tabPanel.hideTabStripItem(3);
								 tabPanel.hideTabStripItem(4);						  

							  }
							 Ext.getCmp('idaguinaldo_si').setValue('1');
							 Ext.getCmp('idaguinaldo2_no').setValue('2');
							 Ext.getCmp('idprima_si').setValue('1');
							 Ext.getCmp('idretroactivo_no').setValue('2');
							 Ext.getCmp('idaportes_patronales_si').setValue('1');
							 Ext.getCmp('idaplica_planilla_si').setValue('1');
							 Ext.getCmp('idindemnizacion_si').setValue('1');
			
							 txtcodigo_dependiente_rc_iva.setValue('');
							 Ext.getCmp('idsindicalizado_no').setValue('2');
			
							 Ext.getCmp('idaplica_aportes_sindicales1_si').setValue('1');
							 txtmonto_aportes_sindicales1.setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales1_fijo').setDisabled(false);
							 Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setValue('1');
							 txtmonto_aportes_sindicales1.setValue('0');
			
							 Ext.getCmp('idaplica_aportes_sindicales2_si').setValue('1');
							   txtmonto_aportes_sindicales2.setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales2_fijo').setDisabled(false);
							 Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setValue('1');
							 txtmonto_aportes_sindicales2.setValue('0');
			
							 cboforma_pago.setValue('');
							 cbotipo_cuenta.setValue('');

							 txtPlanta_Costeo.setValue('');
							 txtProceso_Costeo.setValue('');
							 txttipo_Costeo.setValue('');
			
							 Ext.getCmp('idaplica_afp_si').setValue('1');
							 Ext.getCmp('idesta_jubilado_no').setValue('2');
							 Ext.getCmp('idaporta_afp_si').setValue('1');
							 Ext.getCmp('ides_persona_con_discapacidad_no').setValue('2');
							 Ext.getCmp('ides_tutor_no').setValue('2');
			
							Ext.getCmp('idbono_antiguedad_si').setValue('1');
							Ext.getCmp('idquincena_si').setValue('1');
							txtmonto_aplica_quincena.setDisabled(false);
							Ext.getCmp('idtipoquincena_porcentaje').setDisabled(false);
							Ext.getCmp('idtipoquincena_monto').setDisabled(false);
							Ext.getCmp('idtipoquincena_porcentaje').setValue('1');
							txtmonto_aplica_quincena.setValue('0');
							Ext.getCmp('idaplicaretencion_si').setDisabled(true);
							Ext.getCmp('idaplicaretencion_no').setDisabled(true);
							Ext.getCmp('idaplicaretencion_no').setValue('2');
							Ext.getCmp('idaplica_infocal_no').setValue('2');
							
							var pos = 0;  
							var miArray = new Array(); 
							miArray=[];
							storeConceptos.each(function(record){
								if(record.data.id == 14 || record.data.id == 15 || record.data.id == 16 || record.data.id == 17
									|| record.data.id == 10 || record.data.id == 11 || record.data.id == 12 || record.data.id == 13 || record.data.id == 18
									|| record.data.id == 21 || record.data.id == 22 || record.data.id == 23 || record.data.id == 24 || record.data.id == 25){
									
									record.data.ticket=1;	
								}
								
							});
							var chx = Ext.getCmp('gridConceptos'); 
							chx.getStore().commitChanges();
							chx.getView().refresh();
							var i=0;
							storeConceptos.each(function(record){
	
								if(parseInt(record.data.ticket) == 1){  
									miArray[pos] = i;  
									pos++;  
								}  
								
								i++;
								
								
							});
							
							gridConceptos.getSelectionModel().selectRows(miArray, true);
							
							var chx = Ext.getCmp('gridConceptos'); 
							chx.getStore().commitChanges();
							chx.getView().refresh();
							cboBonoAntiguedad.setValue(0);
							cboBonoAntiguedad.setDisabled(true);
							bono_antiguedad_dif_check=0;
							

							 
						},
						hide: function(){
							gridfoto.removeAll();
						   storeFoto.removeAll();
						   gridfoto.getView().refresh();
						   
					   }
					}
				});
				
			  var ch1 = Ext.getCmp('active');
			   
				
				ch1.setValue(true);
			   
			  active=1;
			txtNombre.setValue("");
			txtFechaBaja.setValue("");
			txtSegNombre.setValue("");
			txtapp.setValue("");
			txtapm.setValue("");
			txtci.setValue("");
			cboTipoDocumento.setValue("");
			txtFechaNacimiento.setValue("");
			txtCorreoPersonal.setValue("");
			cboExtension.setValue("");
			cboNacionalidad.setValue("");
			cboGenero.setValue("");
			cboPais.setValue("");
			cboCiudad.setValue("");			

			 cboProvincia.setValue("");
			 cboTipoSangre.setValue("");
			 txtZona.setValue("");
			txtDireccionDomicilio.setValue("");
			 txtTelefono1.setValue("");
			txtTelefono2.setValue("");
			 txtcelular1.setValue("");
			txtcelular2.setValue("");
			cboEstadoCivil.setValue("");	
			cboPaisDomicilio.setValue("");
			cboRegionalTrabajo.setValue("");
			cboCiudadDomicilio.setValue("");	
			 
			  cboProvinciaDomicilio.setValue("");
			   cboSubCentro.setValue("");
			    cboUnidad.setValue("");
			  cboCentro.setValue("");
			  cboDominical.setValue("");
			  cboCargo.setValue("");
			  txtNroTrabajador.setValue("");
			  cboTipoTrabajador.setValue("");
			  cboOficina.setValue("");
			   txtSueldoBasico.setValue("");
			   txtSueldoVariable.setValue("");
			   txtMinimo.setValue("");
			   txtMidPoint.setValue("");
			   txtMaximo.setValue("");
			   txtPorcentajeRango.setValue("");
			   cboTipoContrato.setValue("");
			   txtFechaIngreso.setValue("");
			   txtFechaIngreso.setDisabled(true);
			   txtFechaFin.setValue("");
			   txtFechaFin.setDisabled(true);
			    txtpais_nacimiento.setValue("BOLIVIA");
			 txtciudad_nacimiento.setValue("");
			 txtprovincia_nacimiento.setValue("");
			 txtpais_domicilio.setValue("BOLIVIA");
			 txtciudad_domicilio.setValue("");
			 txtprovincia_domicilio.setValue("");
			 cboTipoEvaluacion.setValue("");
			 
			  cboJefeDirecto.setValue("");
			   cboJefeArea.setValue("");
			   cboGerenteArea.setValue("");
			   txtcelularCorporativo.setValue("");
			   txtCorreoCorporativo.setValue("");
			   
			    txtNUA.setValue("");
				cboAFP.setValue("");
				cboTIPOAFP.setValue(1);
				txtNumeroAsegurado.setValue("");
				txtBancoParaElAbono.setValue("");
				txtNroCuentaBanco.setValue("");
				cboTipoNovedad.setValue("");
				txtFechaIndemnizacion.setValue("");
				txtFechaParaVacionesEspeciales.setValue("");
				txtFechaCertificadoPTJ.setValue("");
				 txtnacionalidad.setValue("BOLIVIA");
				 cboPlanilla.setValue("");

				 txtTerNombre.setValue('');
				 txtapcasada.setValue('');
				 txtFVencDoc.setValue('');
				 txtprofesion.setValue('');
				 cboNivelInstruccion.setValue('');
				 txtnro_lic.setValue('');
				 txttipo_lic.setValue('');
				 txtfecha_venc_lic.setValue('');
				 txtcontacto_emergencia.setValue('');
				 txttel_contacto.setValue('');
				 txtdir_contacto.setValue('');


				 txtFechaParaBonoAntiguedad.setValue('');
				 cboModalidadTrabajo.setValue('');
				 cboclasificacion_laboral.setValue('');
				 cboTipoContrato_modo.setValue('');
				 txtTelefonoFijoLaboral.setValue('');
				 txtdireccionLaboral.setValue('');

				 txtcamisa_uniforme.setValue('');
				 txtpantalon_uniforme.setValue('');
				 txtchamarra_uniforme.setValue('');
				 txtoverol_uniforme.setValue('');
				 txtbotines_uniforme.setValue('');
				 txtotros_uniforme.setValue('');
				 txtpolera_uniforme.setValue('');
				 
				 txtDiasTrabajadosMes.setValue('0');
				 txtDomingosMes.setValue('0');
				 txtHEMes.setValue('0');
				 txtHEFMes.setValue('0');
				 txtHEDMes.setValue('0');
				 txtRNMes.setValue('0');

				 txtComisionMes.setValue('0');
				 txtOtrosIngresosMes.setValue('0');
				 txtOtrosEgresosMes.setValue('0');

				 txtOtrosIngresosMes2.setValue('0');
				 txtOtrosEgresosMes2.setValue('0');
				 txtrc_iva_f110.setValue('0');
				 txtotros_ing_adicionales_planillaimpo.setValue('0');
				 txtbono_produccion.setValue('0');
				 txtFechaNovedad.setValue('');
				 cboTipoAsegurado.setValue('');
				 cbomotivo_retiro.setValue('');
				 cbotipo_novedad_rc_iva.setValue('');
				 cbofuente_min_eco.setValue('');
				 cboorganismo_min_eco.setValue('');

				 txthaberBasicoPromocion.setValue('');
				 txtDiasDeTrabajoPromocion.setValue('');
				 cboCargoPromocion.setValue('');
				 txtcomplemento.setValue('');

				 txtOtrosegresos1Mes.setValue('');
				 txtOtrosegresos2Mes.setValue('');
				 txtprestamoMes.setValue('');
				 txtseguro_privado_mes.setValue('');
				 txtretencionJudicialMes.setValue('');

				 txtpulperiaMes.setValue('');
				 txtcolaboracion_mes.setValue('');

				 txtVariableBase.setValue('');
				 cboTipoVariable.setValue('');
				 txtInterno.setValue('');

				 txtFechaRequerimiento.setValue('');
				 cbotipo_alta.setValue('');
				 txtReemplaza_requerimiento.setValue('');
				 txtObservacion_baja.setValue('');
				 txtObservacion_requerimiento.setValue('');
				 
				 registros_dep = [];
				 storeDetalleDependiente.loadData(registros_dep);

				 val_aporte=1;
				 val_afp=1;
				
				 storeConceptos.load({params:{codigo: 0,val_aporte:val_aporte,val_afp:val_afp}});// val=1: si corresponde
				 //foto perfil
				 randonfoto=0;
				 fichero_perfil.setValue("");
				 foto="";
					
				 opcion = 0;
				 windatosPersonal.show();
				windatosPersonal.setTitle('PERSONAL');
				/*
				
				*/
			//  cboHorario.setValue("");
		
		}
		function TraerDatosDependientes(idpersonal)
		{
			 
			registros_dep = [];
			storeDetalleDependiente.loadData(registros_dep);
			storeDatosGrid = new Ext.data.JsonStore(
			{
				
				url:'../servicesAjax/DSListaTraerDependientesPersonal.php',   
				root: 'data',  
				totalProperty: 'total',
				fields: ['codigop', 'nombrep','parentescop','cip','fecha_venc_p','idparentescop'],			
				listeners: { 		       
					load: function(thisStore, record, ids) 
					{  					
						var pos = 0;  
							
						for(i = 0; i<this.getCount();i++){
						 
							registro = new Array(13);
							dimension = registros_dep.length;
							
							registro[0] = record[i].data.codigop;
							registro[1] = record[i].data.nombrep;
							registro[2] = record[i].data.parentescop;
							registro[3] = record[i].data.cip;
							registro[4] = record[i].data.fecha_venc_p;
							registro[5] = record[i].data.idparentescop;
							
							registros_dep[dimension] = registro;
							
						}
						
						storeDetalleDependiente.loadData(registros_dep);	
						//storeMarcacionMPm.sort('num','DESC'); 
					}
				}
			});
			storeDatosGrid.load({params:{idpersonal: idpersonal}});
			
			
			
		}
		
		function modPersonal(indice, val_form){
			bandera=1;
			bandera1=1;
			ind=indice;
			
				windatosPersonal = new Ext.Window({
					layout: 'form',
					width: 880,
					height: 750,		
					title: 'PERSONAL',			
					resizable: true,
					closeAction: 'hide',
					closable: true,
					y:0,
					draggable: false,
					plain: true,
					border: false,	
					modal: true,
					autoScroll:true,
					maximized: true,
					items: [PAmenuEmpleadoG,PAmenu],
					listeners: {				
						show: function(){
							var tabPanel = Ext.getCmp("main-tabs");
							  tabPanel.show();
							  tabPanel.setActiveTab("t2");
							  tabPanel.setActiveTab("t5");
							  tabPanel.setActiveTab("t3");
							  tabPanel.setActiveTab("t4");
							 tabPanel.setActiveTab("t1");
							 if(val_form == 'registroAltas'){
								 tabPanel.hideTabStripItem(2);
								 tabPanel.hideTabStripItem(3);
								 tabPanel.hideTabStripItem(4);						  

							  }
							 aplica_aguinaldo1=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_aguinaldo1');
							 if(aplica_aguinaldo1==1)
							 {
								Ext.getCmp('idaguinaldo_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaguinaldo_no').setValue('2');
							 }
							 
							 aplica_aguinaldo2=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_aguinaldo2');
							 if(aplica_aguinaldo2==1)
							 {
								Ext.getCmp('idaguinaldo2_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaguinaldo2_no').setValue('2');
							 }
			
							 aplica_prima=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_prima');
							 if(aplica_prima==1)
							 {
								Ext.getCmp('idprima_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idprima_no').setValue('2');
							 }
			
							 aplica_retroactivo=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_retroactivo');
							 if(aplica_retroactivo==1)
							 {
								Ext.getCmp('idretroactivo_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idretroactivo_no').setValue('2');
							 }
			
							 aplica_aportes_patronales=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_aportes_patronales');
							 if(aplica_aportes_patronales==1)
							 {
								Ext.getCmp('idaportes_patronales_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaportes_patronales_no').setValue('2');
							 }
			
							 aplica_planilla_tributaria=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_planilla_tributaria');
							 if(aplica_planilla_tributaria==1)
							 {
								Ext.getCmp('idaplica_planilla_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaplica_planilla_no').setValue('2');
							 }
			
							 aplica_indemnizacion=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_indemnizacion');
							 if(aplica_indemnizacion==1)
							 {
								Ext.getCmp('idindemnizacion_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idindemnizacion_no').setValue('2');
							 }
			
							
							 txtcodigo_dependiente_rc_iva.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codigo_rc_iva'));
			
							 sindicalizado=Ext.dsdata.storedatospersonal.getAt(indice).get('sindicalizado');
							 if(sindicalizado==1)
							 {
								Ext.getCmp('idsindicalizado_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idsindicalizado_no').setValue('2');
							 }
			
							 aplica_apor_sind1=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_apor_sind1');
							 if(aplica_apor_sind1==1)
							 {
								Ext.getCmp('idaplica_aportes_sindicales1_si').setValue('1');
								txtmonto_aportes_sindicales1.setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales1_fijo').setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('idaplica_aportes_sindicales1_no').setValue('2');
								txtmonto_aportes_sindicales1.setDisabled(true);
								Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setDisabled(true);
								Ext.getCmp('idtipoaportes_sindicales1_fijo').setDisabled(true);
								
							 }
			
							 tipo_monto_apor_sind1=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_monto_apor_sind1');
							 if(tipo_monto_apor_sind1==1)
							 {
								Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idtipoaportes_sindicales1_fijo').setValue('2');
							 }
							 
							 txtmonto_aportes_sindicales1.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('monto_aporte_sind1'));
			
							 aplica_apor_sind2=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_apor_sind2');
							 if(aplica_apor_sind2==1)
							 {
								Ext.getCmp('idaplica_aportes_sindicales2_si').setValue('1');
								txtmonto_aportes_sindicales2.setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales2_fijo').setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('idaplica_aportes_sindicales2_no').setValue('2');
										txtmonto_aportes_sindicales2.setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales2_fijo').setDisabled(true);
							 }
			
							 tipo_monto_apor_sind2=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_monto_apor_sind2');
							 if(tipo_monto_apor_sind2==1)
							 {
								Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idtipoaportes_sindicales2_fijo').setValue('2');
							 }
							 
							 txtmonto_aportes_sindicales2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('monto_aporte_sind2'));
			
							 cboforma_pago.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('forma_pago'));
							 cbotipo_cuenta.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_cuenta'));

							 txtPlanta_Costeo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('planta_costeo'));
							 txtProceso_Costeo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('proceso_costeo'));
							 txttipo_Costeo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_costeo'));
			
							 aplica_afp=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_afp');
							 if(aplica_afp==1)
							 {
								Ext.getCmp('idaplica_afp_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaplica_afp_no').setValue('2');
							 }
			
							 esta_jubilado=Ext.dsdata.storedatospersonal.getAt(indice).get('esta_jubilado');
							 if(esta_jubilado==1)
							 {
								Ext.getCmp('idesta_jubilado_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idesta_jubilado_no').setValue('2');
							 }
			
							 aporta_afp=Ext.dsdata.storedatospersonal.getAt(indice).get('aporta_afp');
							 if(aporta_afp==1)
							 {
								Ext.getCmp('idaporta_afp_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaporta_afp_no').setValue('2');
							 }
			
							 es_persona_con_discapacidad=Ext.dsdata.storedatospersonal.getAt(indice).get('es_persona_con_discapacidad');
							 if(es_persona_con_discapacidad==1)
							 {
								Ext.getCmp('ides_persona_con_discapacidad_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('ides_persona_con_discapacidad_no').setValue('2');
							 }
			
							 es_tutor_de_persona_con_discapacidad=Ext.dsdata.storedatospersonal.getAt(indice).get('es_tutor_de_persona_con_discapacidad');
							 if(es_tutor_de_persona_con_discapacidad==1)
							 {
								Ext.getCmp('ides_tutor_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('ides_tutor_no').setValue('2');
							 }
							
							 bono_anti_para_calc=Ext.dsdata.storedatospersonal.getAt(indice).get('bono_anti_para_calc');
							 if(bono_anti_para_calc==1)
							 {
								Ext.getCmp('idbono_antiguedad_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idbono_antiguedad_no').setValue('2');
							 }
			
							 aplica_quincena=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_quincena');
							 if(aplica_quincena==1)
							 {
								Ext.getCmp('idquincena_si').setValue('1');
								txtmonto_aplica_quincena.setDisabled(false);
								Ext.getCmp('idtipoquincena_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoquincena_monto').setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('idquincena_no').setValue('2');
								txtmonto_aplica_quincena.setDisabled(true);
								Ext.getCmp('idtipoquincena_porcentaje').setDisabled(true);
								Ext.getCmp('idtipoquincena_monto').setDisabled(true);
							 }
							 
							 tipo_monto_quincena=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_monto_quincena');
							 if(tipo_monto_quincena==1)
							 {
								Ext.getCmp('idtipoquincena_porcentaje').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idtipoquincena_monto').setValue('2');
							 }
			
							 txtmonto_aplica_quincena.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('monto_quincena'));
						
							 aplica_infocal=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_infocal');
							 if(aplica_infocal==1)
							 {
								Ext.getCmp('idaplica_infocal_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaplica_infocal_no').setValue('2');
							 }
							 //////////////////////////////
							 aplica_retencion=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_retencion');
							 if(aplica_retencion==1)
							 {
								Ext.getCmp('idaplicaretencion_si').setValue('1');
							 }
							 else
							 {
								
								Ext.getCmp('idaplicaretencion_no').setValue('2');
							 }

							 bono_antiguedad_dif_check=Ext.dsdata.storedatospersonal.getAt(indice).get('check_bonoantiguedad_dif');
							 if(bono_antiguedad_dif_check==1){
								Ext.getCmp('bono_antiguedad_dif').setValue(true);
								cboBonoAntiguedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('categoria_certificada_cas'));
								cboBonoAntiguedad.setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('bono_antiguedad_dif').setValue(false);
								cboBonoAntiguedad.setValue(0);
								cboBonoAntiguedad.setDisabled(true);
							 }
							
							 //'check_bonoantiguedad_dif','categoria_certificada_cas'
						},
						hide: function(){
							gridfoto.removeAll();
						   storeFoto.removeAll();
						   gridfoto.getView().refresh();
						
					   }
					}
				});
				
			
			opcion = 1;
			var fechamovil = Ext.dsdata.storedatospersonal.getAt(indice).get('movil_update');
			windatosPersonal.show();
			if(fechamovil != '0000-00-00 00:00:00'){
				windatosPersonal.setTitle('PERSONAL | ULTIMA ACTUALIZACION DESDE EL MOVIL: '+fechamovil);
			}			
			
			 cboCiudad.enable(false);
			  cboProvincia.enable(false);
			   cboCiudadDomicilio.enable(false);
			  cboProvinciaDomicilio.enable(false);
			  txtFechaFin.setDisabled(false);
			  txtFechaIngreso.setDisabled(false);
			 cboRegionalTrabajo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_region'));
			  cboOficina.setValue('');
			storeOficina.load({params:{cbRegion: cboRegionalTrabajo.getValue()}});
			codigo = Ext.dsdata.storedatospersonal.getAt(indice).get('codigo');
			TraerDatosDependientes(codigo);
			storeConceptos.load({params:{codigo: codigo}});
			txtNombre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('primerNombre'));
			txtSegNombre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('segundoNombre'));
			txtapp.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('app'));
			txtapm.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('apm'));
			txtci.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ci'));
			txtFechaNacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_nacimiento'));
			txtCorreoPersonal.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('correo_personal'));
			cboExtension.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codext'));
			cboNacionalidad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codnac'));
			cboGenero.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('genero'));
			cboPais.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codpais'));
			storeCiudad.load({params:{cbpais: Ext.dsdata.storedatospersonal.getAt(indice).get('codpais')}});
			
			cboCiudad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nombre_ciud'));			
			 storeProvincia.load({params:{cbciudad: Ext.dsdata.storedatospersonal.getAt(indice).get('codciudad')}});
			
			
			 cboProvincia.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nombre_pro'));
			 cboTipoSangre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_tiposangre'));
			 txtZona.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('zona'));
			txtDireccionDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('direcciondomi'));
			 txtTelefono1.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telefono1'));
			txtTelefono2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telefono2'));
			 txtcelular1.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('celular1'));
			txtcelular2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('celular2'));
			cboEstadoCivil.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('estadocivil'));	
			cboPaisDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_pais'));
			storeCiudad.load({params:{cbpais: Ext.dsdata.storedatospersonal.getAt(indice).get('cod_pais')}});
			cboCiudadDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ciudir'));	
			 storeProvincia.load({params:{cbciudad: Ext.dsdata.storedatospersonal.getAt(indice).get('cod_ciud')}});
			  cboProvinciaDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('provdir'));
			  cboUnidad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_unidad'));
			  cboTipoContrato.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato'));
			  cboDominical.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dominical'));
			  txtFechaBaja.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_baja'));////
			  txtObservacion_baja.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('observacion_retiro'));
			  txtObservacion_requerimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('observacion_requerimiento'));
		
			 txtpais_nacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('pais_nacimiento'));
			 txtciudad_nacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ciudad_nacimiento'));
			 txtprovincia_nacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('provincia_nacimiento'));
			 txtpais_domicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('pais_domicilio'));
			 txtciudad_domicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ciudad_domicilio'));
			 txtprovincia_domicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('provincia_domicilio'));
			 cboTipoEvaluacion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_evaluacion'));
			 cboPlanilla.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('planilla'));
			   txtFechaIngreso.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_ingreso'));
			   tipo_contrato=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato');
			   if(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato')==1 )
			  {
							if(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_retiro')=="")
							{
								
								mostrarFecha(89,txtFechaIngreso.getValue());
							}
							else
							{
								txtFechaFin.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_retiro'));
							}
							lblfechaRetir.setText("PERIODO DE PRUEBA:");
							
			  }
			  else
			  {
			   txtFechaFin.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_retiro'));
			   lblfechaRetir.setText("FECHA FINALIZACION:");
			 }
			  cboNivelJerarquico.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_nivel'));
			   
			   cboTipoTrabajador.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_tipo_trabajador'));
			  
			  
			   txtSueldoBasico.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('sueldo_basico'));
			   txtSueldoVariable.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('sueldo_variable'));
			   txtMinimo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('minimo'));
			   txtMidPoint.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('midpoint'));
			   txtMaximo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('maximo'));
			   txtPorcentajeRango.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('porcentaje_rango'));
			   cboJefeDirecto.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('jefedirecto'));
			   cboJefeArea.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('jefe_area'));
			   cboGerenteArea.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('gerente_area'));
			   txtcelularCorporativo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('celular_corporativo'));
			   txtCorreoCorporativo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('correo_corporativo'));
			   
			    txtNUA.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nua'));
				cboAFP.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_afp'));
				cboTIPOAFP.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_tipo_aporte'));
				txtNumeroAsegurado.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nro_asegurado'));
				txtBancoParaElAbono.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('banco_sueldo'));
				txtNroCuentaBanco.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nro_cuenta_banco'));
				cboTipoNovedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_novedad'));
				txtFechaIndemnizacion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_indemnizacion'));
				txtFechaParaVacionesEspeciales.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_vacaciones_especiales'));
				txtFechaCertificadoPTJ.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_certificado_ptj'));
			   txtnacionalidad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nnacionalidad'));
			   
			   var ch1 = Ext.getCmp('active');
			   if(Ext.dsdata.storedatospersonal.getAt(indice).get('activo')==1)
			   {
				active=1;
				ch1.setValue(true);
			   }
			   else
			   {
				active=0;
				ch1.setValue(false);
			   }
						 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										
						 storeSubcentro.load({params:{cbUnidad: cboUnidad.getValue()}});
						 txtTerNombre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tercer_nombre'));
						 txtapcasada.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ap_casada'));
						 txtFVencDoc.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_venc_doc'));
						 txtprofesion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('profesion'));
						 cboNivelInstruccion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nivelinstruccion'));
						 txtnro_lic.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nro_licencia'));
						 txttipo_lic.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_licencia'));
						 txtfecha_venc_lic.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_venc_lic'));
						 txtcontacto_emergencia.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('contacto_emergencia'));
						 txttel_contacto.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telf_emergencia'));
						 txtdir_contacto.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dir_emergencia'));	
						 
				txtFechaParaBonoAntiguedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_bono_ant'));
				 cboModalidadTrabajo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('modalidad_trabajo'));
				 cboclasificacion_laboral.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('clasificacion_laboral'));
				 cboTipoContrato_modo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato_laboral'));
				 txtTelefonoFijoLaboral.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telf_fijo_lab'));
				 txtdireccionLaboral.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dir_lab'));
				   
				 txtcamisa_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_camisa'));
				 txtpantalon_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_pantalon'));
				 txtchamarra_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_chamarra'));
				 txtoverol_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_overol'));
				 txtbotines_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_botines'));
				 txtotros_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_otros'));
				 txtpolera_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_polera'));

				 txtDiasTrabajadosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dias_trabajados_mes'));
				 txtDomingosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('domingos_del_mes'));
				 txtHEMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('horas_extras_mes'));
				 txtHEFMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('horas_extras_feriado_mes'));
				 txtHEDMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('horas_extras_domingo_mes'));
				 txtRNMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('recargo_nocturno_mes'));

				 txtComisionMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('comision_mes'));
				 txtOtrosIngresosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_ingresos_mes'));
				 txtOtrosEgresosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egresos_mes'));

				 txtOtrosIngresosMes2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_ingresos_mes2'));
				 txtOtrosEgresosMes2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egresos_mes2'));
				 txtrc_iva_f110.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('rcv_iva_f110'));
				 txtotros_ing_adicionales_planillaimpo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_ing_adicionales_pi'));
				 txtbono_produccion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('bono_produccion_mes'));

				 txtFechaNovedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_novedad'));
				 cboTipoAsegurado.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('idtipo_asegurado'));
				 cbomotivo_retiro.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('motivo_retiro'));

				 cbotipo_novedad_rc_iva.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_novedades_rc_iva'));

				 cbofuente_min_eco.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fuente_min_economia'));
				 cboorganismo_min_eco.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('organismo_fuente_economia'));


				 txthaberBasicoPromocion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('haber_basico_promocion'));
				 txtDiasDeTrabajoPromocion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dias_trabajados_promocion'));
				 cboCargoPromocion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('idcargo_promocion'));
				 txtcomplemento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('complemento'));

				 txtOtrosegresos1Mes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egre1_mes'));
				 txtOtrosegresos2Mes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egre2_mes'));
				 txtprestamoMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('prestamo_mes'));
				 txtseguro_privado_mes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('seguro_privado_mes'));
				 txtretencionJudicialMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('retencion_judiciales_mes'));
			   	 
				 txtpulperiaMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('pulperia_mes'));
				 txtcolaboracion_mes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('colaboraciones_mes'));
				
				 txtVariableBase.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('variable_base'));
				 cboTipoVariable.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_variable'));

				 cboTipoDocumento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_documento'));
				 txtInterno.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('interno'));

				 txtFechaRequerimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_requerimiento'));
				 cbotipo_alta.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_alta_requerimiento'));
				 txtReemplaza_requerimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('reemplazo_requerimiento'));

				 //foto perfil
				 fichero_perfil.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('foto'));
				randonfoto=0;
				foto = Ext.dsdata.storedatospersonal.getAt(indice).get('foto');
				ActualizarGrid(foto);
	 
		}
	function replicarPersonal(indice, val_form){
			bandera=2;
			bandera1=1;
			ind=indice;
			
				windatosPersonal = new Ext.Window({
					layout: 'form',
					width: 880,
					height: 750,		
					title: 'PERSONAL',			
					resizable: true,
					closeAction: 'hide',
					closable: true,
					y:0,
					draggable: false,
					plain: true,
					border: false,	
					modal: true,
					autoScroll:true,
					maximized: true,
					items: [PAmenuEmpleadoG,PAmenu],
					listeners: {				
						show: function(){
							var tabPanel = Ext.getCmp("main-tabs");
							  tabPanel.show();
							  tabPanel.setActiveTab("t2");
							  tabPanel.setActiveTab("t5");
							  tabPanel.setActiveTab("t3");
							  tabPanel.setActiveTab("t4");
							 tabPanel.setActiveTab("t1");
							 if(val_form == 'registroAltas'){
								 tabPanel.hideTabStripItem(2);
								 tabPanel.hideTabStripItem(3);
								 tabPanel.hideTabStripItem(4);						  

							  }
							 aplica_aguinaldo1=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_aguinaldo1');
							 if(aplica_aguinaldo1==1)
							 {
								Ext.getCmp('idaguinaldo_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaguinaldo_no').setValue('2');
							 }
							 
							 aplica_aguinaldo2=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_aguinaldo2');
							 if(aplica_aguinaldo2==1)
							 {
								Ext.getCmp('idaguinaldo2_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaguinaldo2_no').setValue('2');
							 }
			
							 aplica_prima=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_prima');
							 if(aplica_prima==1)
							 {
								Ext.getCmp('idprima_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idprima_no').setValue('2');
							 }
			
							 aplica_retroactivo=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_retroactivo');
							 if(aplica_retroactivo==1)
							 {
								Ext.getCmp('idretroactivo_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idretroactivo_no').setValue('2');
							 }
			
							 aplica_aportes_patronales=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_aportes_patronales');
							 if(aplica_aportes_patronales==1)
							 {
								Ext.getCmp('idaportes_patronales_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaportes_patronales_no').setValue('2');
							 }
			
							 aplica_planilla_tributaria=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_planilla_tributaria');
							 if(aplica_planilla_tributaria==1)
							 {
								Ext.getCmp('idaplica_planilla_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaplica_planilla_no').setValue('2');
							 }
			
							 aplica_indemnizacion=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_indemnizacion');
							 if(aplica_indemnizacion==1)
							 {
								Ext.getCmp('idindemnizacion_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idindemnizacion_no').setValue('2');
							 }
			
							
							 txtcodigo_dependiente_rc_iva.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codigo_rc_iva'));
			
							 sindicalizado=Ext.dsdata.storedatospersonal.getAt(indice).get('sindicalizado');
							 if(sindicalizado==1)
							 {
								Ext.getCmp('idsindicalizado_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idsindicalizado_no').setValue('2');
							 }
			
							 aplica_apor_sind1=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_apor_sind1');
							 if(aplica_apor_sind1==1)
							 {
								Ext.getCmp('idaplica_aportes_sindicales1_si').setValue('1');
								txtmonto_aportes_sindicales1.setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales1_fijo').setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('idaplica_aportes_sindicales1_no').setValue('2');
								txtmonto_aportes_sindicales1.setDisabled(true);
								Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setDisabled(true);
								Ext.getCmp('idtipoaportes_sindicales1_fijo').setDisabled(true);
								
							 }
			
							 tipo_monto_apor_sind1=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_monto_apor_sind1');
							 if(tipo_monto_apor_sind1==1)
							 {
								Ext.getCmp('idtipoaportes_sindicales1_porcentaje').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idtipoaportes_sindicales1_fijo').setValue('2');
							 }
							 
							 txtmonto_aportes_sindicales1.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('monto_aporte_sind1'));
			
							 aplica_apor_sind2=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_apor_sind2');
							 if(aplica_apor_sind2==1)
							 {
								Ext.getCmp('idaplica_aportes_sindicales2_si').setValue('1');
								txtmonto_aportes_sindicales2.setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoaportes_sindicales2_fijo').setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('idaplica_aportes_sindicales2_no').setValue('2');
										txtmonto_aportes_sindicales2.setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setDisabled(true);
										Ext.getCmp('idtipoaportes_sindicales2_fijo').setDisabled(true);
							 }
			
							 tipo_monto_apor_sind2=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_monto_apor_sind2');
							 if(tipo_monto_apor_sind2==1)
							 {
								Ext.getCmp('idtipoaportes_sindicales2_porcentaje').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idtipoaportes_sindicales2_fijo').setValue('2');
							 }
							 
							 txtmonto_aportes_sindicales2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('monto_aporte_sind2'));
			
							 cboforma_pago.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('forma_pago'));
							 cbotipo_cuenta.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_cuenta'));
			
							 aplica_afp=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_afp');
							 if(aplica_afp==1)
							 {
								Ext.getCmp('idaplica_afp_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaplica_afp_no').setValue('2');
							 }
			
							 esta_jubilado=Ext.dsdata.storedatospersonal.getAt(indice).get('esta_jubilado');
							 if(esta_jubilado==1)
							 {
								Ext.getCmp('idesta_jubilado_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idesta_jubilado_no').setValue('2');
							 }
			
							 aporta_afp=Ext.dsdata.storedatospersonal.getAt(indice).get('aporta_afp');
							 if(aporta_afp==1)
							 {
								Ext.getCmp('idaporta_afp_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaporta_afp_no').setValue('2');
							 }
			
							 es_persona_con_discapacidad=Ext.dsdata.storedatospersonal.getAt(indice).get('es_persona_con_discapacidad');
							 if(es_persona_con_discapacidad==1)
							 {
								Ext.getCmp('ides_persona_con_discapacidad_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('ides_persona_con_discapacidad_no').setValue('2');
							 }
			
							 es_tutor_de_persona_con_discapacidad=Ext.dsdata.storedatospersonal.getAt(indice).get('es_tutor_de_persona_con_discapacidad');
							 if(es_tutor_de_persona_con_discapacidad==1)
							 {
								Ext.getCmp('ides_tutor_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('ides_tutor_no').setValue('2');
							 }
							
							 bono_anti_para_calc=Ext.dsdata.storedatospersonal.getAt(indice).get('bono_anti_para_calc');
							 if(bono_anti_para_calc==1)
							 {
								Ext.getCmp('idbono_antiguedad_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idbono_antiguedad_no').setValue('2');
							 }
			
							 aplica_quincena=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_quincena');
							 if(aplica_quincena==1)
							 {
								Ext.getCmp('idquincena_si').setValue('1');
								txtmonto_aplica_quincena.setDisabled(false);
								Ext.getCmp('idtipoquincena_porcentaje').setDisabled(false);
								Ext.getCmp('idtipoquincena_monto').setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('idquincena_no').setValue('2');
								txtmonto_aplica_quincena.setDisabled(true);
								Ext.getCmp('idtipoquincena_porcentaje').setDisabled(true);
								Ext.getCmp('idtipoquincena_monto').setDisabled(true);
							 }
							 
							 tipo_monto_quincena=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_monto_quincena');
							 if(tipo_monto_quincena==1)
							 {
								Ext.getCmp('idtipoquincena_porcentaje').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idtipoquincena_monto').setValue('2');
							 }
			
							 txtmonto_aplica_quincena.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('monto_quincena'));
						
							 aplica_infocal=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_infocal');
							 if(aplica_infocal==1)
							 {
								Ext.getCmp('idaplica_infocal_si').setValue('1');
							 }
							 else
							 {
								Ext.getCmp('idaplica_infocal_no').setValue('2');
							 }
							 //////////////////////////////
							 aplica_retencion=Ext.dsdata.storedatospersonal.getAt(indice).get('aplica_retencion');
							 if(aplica_retencion==1)
							 {
								Ext.getCmp('idaplicaretencion_si').setValue('1');
							 }
							 else
							 {
								
								Ext.getCmp('idaplicaretencion_no').setValue('2');
							 }

							 bono_antiguedad_dif_check=Ext.dsdata.storedatospersonal.getAt(indice).get('check_bonoantiguedad_dif');
							 if(bono_antiguedad_dif_check==1){
								Ext.getCmp('bono_antiguedad_dif').setValue(true);
								cboBonoAntiguedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('categoria_certificada_cas'));
								cboBonoAntiguedad.setDisabled(false);
							 }
							 else
							 {
								Ext.getCmp('bono_antiguedad_dif').setValue(false);
								cboBonoAntiguedad.setValue(0);
								cboBonoAntiguedad.setDisabled(true);
							 }
							
							 //'check_bonoantiguedad_dif','categoria_certificada_cas'
						}
					}
				});
				
			
			opcion = 0;
			 txtNroTrabajador.setValue("");
			var fechamovil = Ext.dsdata.storedatospersonal.getAt(indice).get('movil_update');
			windatosPersonal.show();
			// if(fechamovil != '0000-00-00 00:00:00'){
				// windatosPersonal.setTitle('PERSONAL | ULTIMA ACTUALIZACION DESDE EL MOVIL: '+fechamovil);
			// }			
			
			 cboCiudad.enable(false);
			  cboProvincia.enable(false);
			   cboCiudadDomicilio.enable(false);
			  cboProvinciaDomicilio.enable(false);
			  txtFechaFin.setDisabled(false);
			  txtFechaIngreso.setDisabled(false);
			 cboRegionalTrabajo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_region'));
			  cboOficina.setValue('');
			storeOficina.load({params:{cbRegion: cboRegionalTrabajo.getValue()}});
			codigo = Ext.dsdata.storedatospersonal.getAt(indice).get('codigo');
			TraerDatosDependientes(codigo);
			storeConceptos.load({params:{codigo: codigo}});
			txtNombre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('primerNombre'));
			txtSegNombre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('segundoNombre'));
			txtapp.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('app'));
			txtapm.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('apm'));
			txtci.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ci'));
			txtFechaNacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_nacimiento'));
			txtCorreoPersonal.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('correo_personal'));
			cboExtension.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codext'));
			cboNacionalidad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codnac'));
			cboGenero.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('genero'));
			cboPais.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('codpais'));
			storeCiudad.load({params:{cbpais: Ext.dsdata.storedatospersonal.getAt(indice).get('codpais')}});
			
			cboCiudad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nombre_ciud'));			
			 storeProvincia.load({params:{cbciudad: Ext.dsdata.storedatospersonal.getAt(indice).get('codciudad')}});
			
			
			 cboProvincia.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nombre_pro'));
			 cboTipoSangre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_tiposangre'));
			 txtZona.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('zona'));
			txtDireccionDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('direcciondomi'));
			 txtTelefono1.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telefono1'));
			txtTelefono2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telefono2'));
			 txtcelular1.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('celular1'));
			txtcelular2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('celular2'));
			cboEstadoCivil.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('estadocivil'));	
			cboPaisDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_pais'));
			storeCiudad.load({params:{cbpais: Ext.dsdata.storedatospersonal.getAt(indice).get('cod_pais')}});
			cboCiudadDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ciudir'));	
			 storeProvincia.load({params:{cbciudad: Ext.dsdata.storedatospersonal.getAt(indice).get('cod_ciud')}});
			  cboProvinciaDomicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('provdir'));
			  cboUnidad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_unidad'));
			  cboTipoContrato.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato'));
			  cboDominical.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dominical'));
			  // txtFechaBaja.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_baja'));////
			  txtFechaBaja.setValue("");////
		
			 txtpais_nacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('pais_nacimiento'));
			 txtciudad_nacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ciudad_nacimiento'));
			 txtprovincia_nacimiento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('provincia_nacimiento'));
			 txtpais_domicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('pais_domicilio'));
			 txtciudad_domicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ciudad_domicilio'));
			 txtprovincia_domicilio.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('provincia_domicilio'));
			 cboTipoEvaluacion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_evaluacion'));
			 cboPlanilla.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('planilla'));
			   // txtFechaIngreso.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_ingreso'));
			   txtFechaIngreso.setValue("");
			   tipo_contrato=Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato');
			   if(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato')==1 )
			  {
							if(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_retiro')=="")
							{
								
								mostrarFecha(89,txtFechaIngreso.getValue());
							}
							else
							{
								txtFechaFin.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_retiro'));
							}
							lblfechaRetir.setText("PERIODO DE PRUEBA:");
							
			  }
			  else
			  {
			   txtFechaFin.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_retiro'));
			   lblfechaRetir.setText("FECHA FINALIZACION:");
			 }
			  cboNivelJerarquico.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_nivel'));
			   
			   cboTipoTrabajador.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_tipo_trabajador'));
			  
			  
			   txtSueldoBasico.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('sueldo_basico'));
			   txtSueldoVariable.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('sueldo_variable'));
			   txtMinimo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('minimo'));
			   txtMidPoint.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('midpoint'));
			   txtMaximo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('maximo'));
			   txtPorcentajeRango.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('porcentaje_rango'));
			   cboJefeDirecto.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('jefedirecto'));
			   cboJefeArea.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('jefe_area'));
			   cboGerenteArea.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('gerente_area'));
			   txtcelularCorporativo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('celular_corporativo'));
			   txtCorreoCorporativo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('correo_corporativo'));
			   
			    txtNUA.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nua'));
				cboAFP.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_afp'));
				cboTIPOAFP.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('cod_tipo_aporte'));
				txtNumeroAsegurado.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nro_asegurado'));
				txtBancoParaElAbono.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('banco_sueldo'));
				txtNroCuentaBanco.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nro_cuenta_banco'));
				cboTipoNovedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_novedad'));
				// txtFechaIndemnizacion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_indemnizacion'));
				txtFechaIndemnizacion.setValue("");
				// txtFechaParaVacionesEspeciales.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_vacaciones_especiales'));
				txtFechaParaVacionesEspeciales.setValue("");
				txtFechaCertificadoPTJ.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_certificado_ptj'));
			   txtnacionalidad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nnacionalidad'));
			   
			   // var ch1 = Ext.getCmp('active');
			   // if(Ext.dsdata.storedatospersonal.getAt(indice).get('activo')==1)
			   // {
				
				// ch1.setValue(true);
			   // }
			   // else
			   // {
				
				// ch1.setValue(false);
			   // }
			   Ext.getCmp('active').setValue(true);
						 Ext.Msg.wait('Verificando Disponibilidad... Espere por favor!');
										
						 storeSubcentro.load({params:{cbUnidad: cboUnidad.getValue()}});
						 txtTerNombre.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tercer_nombre'));
						 txtapcasada.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('ap_casada'));
						 txtFVencDoc.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_venc_doc'));
						 txtprofesion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('profesion'));
						 cboNivelInstruccion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nivelinstruccion'));
						 txtnro_lic.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('nro_licencia'));
						 txttipo_lic.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_licencia'));
						 txtfecha_venc_lic.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_venc_lic'));
						 txtcontacto_emergencia.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('contacto_emergencia'));
						 txttel_contacto.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telf_emergencia'));
						 txtdir_contacto.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dir_emergencia'));	
						 
				// txtFechaParaBonoAntiguedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_bono_ant'));
				txtFechaParaBonoAntiguedad.setValue("");
				 cboModalidadTrabajo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('modalidad_trabajo'));
				 cboclasificacion_laboral.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('clasificacion_laboral'));
				 cboTipoContrato_modo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_contrato_laboral'));
				 txtTelefonoFijoLaboral.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('telf_fijo_lab'));
				 txtdireccionLaboral.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dir_lab'));
				   
				 txtcamisa_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_camisa'));
				 txtpantalon_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_pantalon'));
				 txtchamarra_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_chamarra'));
				 txtoverol_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_overol'));
				 txtbotines_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_botines'));
				 txtotros_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_otros'));
				 txtpolera_uniforme.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('r_polera'));

				 txtDiasTrabajadosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dias_trabajados_mes'));
				 txtDomingosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('domingos_del_mes'));
				 txtHEMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('horas_extras_mes'));
				 txtHEFMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('horas_extras_feriado_mes'));
				 txtHEDMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('horas_extras_domingo_mes'));
				 txtRNMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('recargo_nocturno_mes'));

				 txtComisionMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('comision_mes'));
				 txtOtrosIngresosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_ingresos_mes'));
				 txtOtrosEgresosMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egresos_mes'));

				 txtOtrosIngresosMes2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_ingresos_mes2'));
				 txtOtrosEgresosMes2.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egresos_mes2'));
				 txtrc_iva_f110.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('rcv_iva_f110'));
				 txtotros_ing_adicionales_planillaimpo.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_ing_adicionales_pi'));
				 txtbono_produccion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('bono_produccion_mes'));
				 txtFechaNovedad.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fecha_novedad'));

				 // cbomotivo_retiro.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('motivo_retiro'));
				 cbomotivo_retiro.setValue("");

				 cbotipo_novedad_rc_iva.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_novedades_rc_iva'));

				 cbofuente_min_eco.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('fuente_min_economia'));
				 cboorganismo_min_eco.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('organismo_fuente_economia'));


				 txthaberBasicoPromocion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('haber_basico_promocion'));
				 txtDiasDeTrabajoPromocion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('dias_trabajados_promocion'));
				 cboCargoPromocion.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('idcargo_promocion'));
				 txtcomplemento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('complemento'));

				 txtOtrosegresos1Mes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egre1_mes'));
				 txtOtrosegresos2Mes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('otros_egre2_mes'));
				 txtprestamoMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('prestamo_mes'));
				 txtseguro_privado_mes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('seguro_privado_mes'));
				 txtretencionJudicialMes.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('retencion_judiciales_mes'));
				 txtVariableBase.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('variable_base'));
				 cboTipoVariable.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_variable'));

				 cboTipoDocumento.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('tipo_documento'));
				 txtInterno.setValue(Ext.dsdata.storedatospersonal.getAt(indice).get('interno'));
	 
		}
