<!--
cityareacode = new Array();
cityarea = new Array();
cityarea_account = new Array();

cityarea_account[0] = 0;

cityarea[1] = '仁愛區';
cityarea[2] = '信義區';
cityarea[3] = '中正區';
cityarea[4] = '中山區';
cityarea[5] = '安樂區';
cityarea[6] = '暖暖區';
cityarea[7] = '七堵區';
cityarea_account[1] = 7;

cityarea[8] = '中正區';
cityarea[9] = '大同區';
cityarea[10] = '中山區';
cityarea[11] = '松山區';
cityarea[12] = '大安區';
cityarea[13] = '萬華區';
cityarea[14] = '信義區';
cityarea[15] = '士林區';
cityarea[16] = '北投區';
cityarea[17] = '內湖區';
cityarea[18] = '南港區';
cityarea[19] = '文山區';
cityarea_account[2] = 19;

cityarea[20] = '八里鄉';
cityarea[21] = '三峽鎮';
cityarea[22] = '樹林市';
cityarea[23] = '鶯歌鎮';
cityarea[24] = '三重市';
cityarea[25] = '新莊市';
cityarea[26] = '泰山鄉';
cityarea[27] = '林口鄉';
cityarea[28] = '三芝鄉';
cityarea[29] = '五股鄉';
cityarea[30] = '淡水鎮';
cityarea[31] = '土城市';
cityarea[32] = '新店市';
cityarea[33] = '蘆洲市';
cityarea[34] = '金山鄉';
cityarea[35] = '烏來鄉';
cityarea[36] = '萬里鄉';
cityarea[37] = '中和市';
cityarea[38] = '板橋市';
cityarea[39] = '汐止市';
cityarea[40] = '深坑鄉';
cityarea[41] = '石碇鄉';
cityarea[42] = '平溪鄉';
cityarea[43] = '雙溪鄉';
cityarea[44] = '貢寮鄉';
cityarea[45] = '石門鄉';
cityarea[46] = '坪林鄉';
cityarea[47] = '永和市';
cityarea[48] = '瑞芳鎮';
cityarea_account[3] = 48;

cityarea[49] = '復興鄉';
cityarea[50] = '平鎮市';
cityarea[51] = '龍潭鄉';
cityarea[52] = '楊梅鎮';
cityarea[53] = '新屋鄉';
cityarea[54] = '觀音鄉';
cityarea[55] = '桃園市';
cityarea[56] = '龜山鄉';
cityarea[57] = '蘆竹鄉';
cityarea[58] = '大溪鎮';
cityarea[59] = '大園鄉';
cityarea[60] = '中壢市';
cityarea[61] = '八德市';
cityarea_account[4] = 61;

cityarea[62] = '東區';
cityarea[63] = '北區';
cityarea[64] = '香山區';
cityarea_account[5] = 64;

cityarea[65] = '新豐鄉';
cityarea[66] = '竹北市';
cityarea[67] = '峨眉鄉';
cityarea[68] = '湖口鄉';
cityarea[69] = '新埔鎮';
cityarea[70] = '關西鎮';
cityarea[71] = '寶山鄉';
cityarea[72] = '竹東鎮';
cityarea[73] = '五峰鄉';
cityarea[74] = '橫山鄉';
cityarea[75] = '芎林鄉';
cityarea[76] = '北埔鄉';
cityarea[77] = '尖石鄉';
cityarea_account[6] = 77;

cityarea[78] = '西湖鄉';
cityarea[79] = '公館鄉';
cityarea[80] = '大湖鄉';
cityarea[81] = '泰安鄉';
cityarea[82] = '卓蘭鎮';
cityarea[83] = '三義鄉';
cityarea[84] = '頭屋鄉';
cityarea[85] = '南庄鄉';
cityarea[86] = '銅鑼鄉';
cityarea[87] = '造橋鄉';
cityarea[88] = '苗栗市';
cityarea[89] = '苑裡鎮';
cityarea[90] = '通霄鎮';
cityarea[91] = '獅潭鄉';
cityarea[92] = '三灣鄉';
cityarea[93] = '頭份鎮';
cityarea[94] = '竹南鎮';
cityarea[95] = '後龍鎮';
cityarea_account[7] = 95;

cityarea[96] = '南屯區';
cityarea[97] = '西屯區';
cityarea[98] = '北區';
cityarea[99] = '北屯區';
cityarea[100] = '南區';
cityarea[101] = '中區';
cityarea[102] = '西區';
cityarea[103] = '東區';
cityarea[104] = '大肚鄉';
cityarea[105] = '大安鄉';
cityarea[106] = '外埔鄉';
cityarea[107] = '大甲鎮';
cityarea[108] = '清水鎮';
cityarea[109] = '梧棲鎮';
cityarea[110] = '沙鹿鎮';
cityarea[111] = '神岡鄉';
cityarea[112] = '大雅鄉';
cityarea[113] = '潭子鄉';
cityarea[114] = '豐原市';
cityarea[115] = '龍井鄉';
cityarea[116] = '新社鄉';
cityarea[117] = '太平市';
cityarea[118] = '烏日鄉';
cityarea[119] = '大里市';
cityarea[120] = '后里鄉';
cityarea[121] = '石岡鄉';
cityarea[122] = '東勢鎮';
cityarea[123] = '和平鄉';
cityarea[124] = '霧峰鄉';
cityarea_account[8] = 124;
cityarea[125] = '埔鹽鄉';
cityarea[126] = '大村鄉';
cityarea[127] = '田中鎮';
cityarea[128] = '北斗鎮';
cityarea[129] = '二水鄉';
cityarea[130] = '埤頭鄉';
cityarea[131] = '竹塘鄉';
cityarea[132] = '二林鎮';
cityarea[133] = '芳苑鄉';
cityarea[134] = '溪湖鎮';
cityarea[135] = '田尾鄉';
cityarea[136] = '大城鄉';
cityarea[137] = '秀水鄉';
cityarea[138] = '埔心鄉';
cityarea[139] = '溪州鄉';
cityarea[140] = '彰化市';
cityarea[141] = '花壇鄉';
cityarea[142] = '鹿港鎮';
cityarea[143] = '福興鄉';
cityarea[144] = '線西鄉';
cityarea[145] = '和美鎮';
cityarea[146] = '伸港鄉';
cityarea[147] = '員林鎮';
cityarea[148] = '社頭鄉';
cityarea[149] = '永靖鄉';
cityarea[150] = '芬園鄉';

cityarea_account[9] = 150;
cityarea[151] = '中寮鄉';
cityarea[152] = '集集鎮';
cityarea[153] = '國姓鄉';
cityarea[154] = '埔里鎮';
cityarea[155] = '仁愛鄉';
cityarea[156] = '名間鄉';
cityarea[157] = '水里鄉';
cityarea[158] = '魚池鄉';
cityarea[159] = '信義鄉';
cityarea[160] = '草屯鎮';
cityarea[161] = '南投市';
cityarea[162] = '鹿谷鄉';
cityarea[163] = '竹山鎮';

cityarea_account[10] = 163;

cityarea[164] = '土庫鎮';
cityarea[165] = '古坑鄉';
cityarea[166] = '斗南鎮';
cityarea[167] = '大埤鄉';
cityarea[168] = '虎尾鎮';
cityarea[169] = '北港鎮';
cityarea[170] = '元長鄉';
cityarea[171] = '四湖鄉';
cityarea[172] = '斗六市';
cityarea[173] = '水林鄉';
cityarea[174] = '褒忠鄉';
cityarea[175] = '二崙鄉';
cityarea[176] = '西螺鎮';
cityarea[177] = '莿桐鄉';
cityarea[178] = '林內鄉';
cityarea[179] = '麥寮鄉';
cityarea[180] = '崙背鄉';
cityarea[181] = '台西鄉';
cityarea[182] = '東勢鄉';
cityarea[183] = '口湖鄉';
cityarea_account[11] = 183;
cityarea[184] = '嘉義市';
cityarea[185] = '大埔鄉';
cityarea[186] = '番路鄉';
cityarea[187] = '梅山鄉';
cityarea[188] = '竹崎鄉';
cityarea[189] = '六腳鄉';
cityarea[190] = '中埔鄉';
cityarea[191] = '布袋鎮';
cityarea[192] = '義竹鄉';
cityarea[193] = '溪口鄉';
cityarea[194] = '大林鎮';
cityarea[195] = '新港鄉';
cityarea[196] = '東石鄉';
cityarea[197] = '朴子市';
cityarea[198] = '太保市';
cityarea[199] = '鹿草鄉';
cityarea[200] = '水上鄉';
cityarea[201] = '阿里山';
cityarea[202] = '民雄鄉';

cityarea_account[12] = 202;
cityarea[203] = '南區';
cityarea[204] = '北區';
cityarea[205] = '安南區';
cityarea[206] = '東區';
cityarea[207] = '中西區';
cityarea[208] = '安平區';
cityarea[209] = '善化鎮';
cityarea[210] = '學甲鎮';
cityarea[211] = '新營市';
cityarea[212] = '白河鎮';
cityarea[213] = '東山鄉';
cityarea[214] = '六甲鄉';
cityarea[215] = '下營鄉';
cityarea[216] = '鹽水鎮';
cityarea[217] = '北門鄉';
cityarea[218] = '大內鄉';
cityarea[219] = '山上鄉';
cityarea[220] = '新市鄉';
cityarea[221] = '安定鄉';
cityarea[222] = '將軍鄉';
cityarea[223] = '柳營鄉';
cityarea[224] = '南化鄉';
cityarea[225] = '七股鄉';
cityarea[226] = '歸仁鄉';
cityarea[227] = '新化鎮';
cityarea[228] = '左鎮鄉';
cityarea[229] = '後壁鄉';
cityarea[230] = '楠西鄉';
cityarea[231] = '仁德鄉';
cityarea[232] = '關廟鄉';
cityarea[233] = '龍崎鄉';
cityarea[234] = '官田鄉';
cityarea[235] = '麻豆鎮';
cityarea[236] = '佳里鎮';
cityarea[237] = '永康市';
cityarea[238] = '西港鄉';
cityarea[239] = '玉井鄉';
cityarea_account[13] = 239;
cityarea[240] = '鹽埕區';
cityarea[241] = '左營區';
cityarea[242] = '小港區';
cityarea[243] = '楠梓區';
cityarea[244] = '三民區';
cityarea[245] = '前鎮區';
cityarea[246] = '苓雅區';
cityarea[247] = '前金區';
cityarea[248] = '新興區';
cityarea[249] = '鼓山區';
cityarea[250] = '旗津區';
cityarea[251] = '桃源鄉';
cityarea[252] = '大寮鄉';
cityarea[253] = '林園鄉';
cityarea[254] = '鳥松鄉';
cityarea[255] = '茄萣鄉';
cityarea[256] = '旗山鎮';
cityarea[257] = '六龜鄉';
cityarea[258] = '內門鄉';
cityarea[259] = '甲仙鄉';
cityarea[260] = '三民鄉';
cityarea[261] = '茂林鄉';
cityarea[262] = '大樹鄉';
cityarea[263] = '鳳山市';
cityarea[264] = '杉林鄉';
cityarea[265] = '岡山鎮';
cityarea[266] = '美濃鎮';
cityarea[267] = '仁武鄉';
cityarea[268] = '大社鄉';
cityarea[269] = '湖內鄉';
cityarea[270] = '路竹鄉';
cityarea[271] = '阿蓮鄉';
cityarea[272] = '彌陀鄉';
cityarea[273] = '永安鄉';
cityarea[274] = '田寮鄉';
cityarea[275] = '梓官鄉';
cityarea[276] = '橋頭鄉';
cityarea[277] = '燕巢鄉';
cityarea_account[14] = 277;
cityarea[278] = '林邊鄉';
cityarea[279] = '春日鄉';
cityarea[280] = '內埔鄉';
cityarea[281] = '潮州鎮';
cityarea[282] = '來義鄉';
cityarea[283] = '萬巒鄉';
cityarea[284] = '崁頂鄉';
cityarea[285] = '新埤鄉';
cityarea[286] = '南州鄉';
cityarea[287] = '泰武鄉';
cityarea[288] = '東港鎮';
cityarea[289] = '琉球鄉';
cityarea[290] = '佳冬鄉';
cityarea[291] = '新園鄉';
cityarea[292] = '麟洛鄉';
cityarea[293] = '枋山鄉';
cityarea[294] = '竹田鄉';
cityarea[295] = '獅子鄉';
cityarea[296] = '車城鄉';
cityarea[297] = '牡丹鄉';
cityarea[298] = '恆春鎮';
cityarea[299] = '滿州鄉';
cityarea[300] = '枋寮鄉';
cityarea[301] = '霧台鄉';
cityarea[302] = '萬丹鄉';
cityarea[303] = '三地門';
cityarea[304] = '長治鄉';
cityarea[305] = '瑪家鄉';
cityarea[306] = '九如鄉';
cityarea[307] = '高樹鄉';
cityarea[308] = '屏東市';
cityarea[309] = '里港鄉';
cityarea[310] = '鹽埔鄉';


cityarea_account[15] = 310;
cityarea[311] = '東河鄉';
cityarea[312] = '台東市';
cityarea[313] = '綠島鄉';
cityarea[314] = '延平鄉';
cityarea[315] = '達仁鄉';
cityarea[316] = '卑南鄉';
cityarea[317] = '鹿野鄉';
cityarea[318] = '關山鎮';
cityarea[319] = '海端鄉';
cityarea[320] = '金峰鄉';
cityarea[321] = '太麻里';
cityarea[322] = '長濱鄉';
cityarea[323] = '成功鎮';
cityarea[324] = '大武鄉';
cityarea[325] = '池上鄉';
cityarea[326] = '蘭嶼鄉';

cityarea_account[16] = 326;
cityarea[327] = '瑞穗鄉';
cityarea[328] = '玉里鎮';
cityarea[329] = '卓溪鄉';
cityarea[330] = '萬榮鄉';
cityarea[331] = '富里鄉';
cityarea[332] = '豐濱鄉';
cityarea[333] = '光復鄉';
cityarea[334] = '鳳林鎮';
cityarea[335] = '壽豐鄉';
cityarea[336] = '吉安鄉';
cityarea[337] = '秀林鄉';
cityarea[338] = '花蓮市';
cityarea[339] = '新城鄉';



cityarea_account[17] = 339;

cityarea[340] = '南澳鄉';
cityarea[341] = '宜蘭市';
cityarea[342] = '頭城鎮';
cityarea[343] = '礁溪鄉';
cityarea[344] = '壯圍鄉';
cityarea[345] = '員山鄉';
cityarea[346] = '羅東鎮';
cityarea[347] = '三星鄉';
cityarea[348] = '大同鄉';
cityarea[349] = '五結鄉';
cityarea[350] = '蘇澳鎮';
cityarea[351] = '冬山鄉';
cityarea_account[18] = 351;

cityarea[352] = '馬公市';
cityarea[353] = '望安鄉';
cityarea[354] = '七美鄉';
cityarea[355] = '白沙鄉';
cityarea[356] = '湖西鄉';
cityarea[357] = '西嶼鄉';
cityarea_account[19] = 357;

cityarea[358] = '金寧鄉';
cityarea[359] = '金湖鎮';
cityarea[360] = '金城鎮';
cityarea[361] = '烈嶼鄉';
cityarea[362] = '烏坵鄉';
cityarea[363] = '金沙鎮';
cityarea_account[20] = 363;

cityarea[364] = '南竿鄉';
cityarea[365] = '東引鄉';
cityarea[366] = '莒光鄉';
cityarea[367] = '北竿鄉';
cityarea_account[21] = 367;
cityarea[368] = '其它';





city_account = 21;

cityareacode[1]='200';
cityareacode[2]='201';
cityareacode[3]='202';
cityareacode[4]='203';
cityareacode[5]='204';
cityareacode[6]='205';
cityareacode[7]='206';

cityareacode[8]='100';
cityareacode[9]='103';
cityareacode[10]='104';
cityareacode[11]='105';
cityareacode[12]='106';
cityareacode[13]='108';
cityareacode[14]='110';
cityareacode[15]='111';
cityareacode[16]='112';
cityareacode[17]='114';
cityareacode[18]='115';
cityareacode[19]='116';

cityareacode[20]='249';
cityareacode[21]='237';
cityareacode[22]='238';
cityareacode[23]='239';
cityareacode[24]='241';
cityareacode[25]='242';
cityareacode[26]='243';
cityareacode[27]='244';
cityareacode[28]='252';
cityareacode[29]='248';
cityareacode[30]='251';
cityareacode[31]='236';
cityareacode[32]='231';
cityareacode[33]='247';
cityareacode[34]='208';
cityareacode[35]='233';
cityareacode[36]='207';
cityareacode[37]='235';
cityareacode[38]='220';
cityareacode[39]='221';
cityareacode[40]='222';
cityareacode[41]='223';
cityareacode[42]='226';
cityareacode[43]='227';
cityareacode[44]='228';
cityareacode[45]='253';
cityareacode[46]='232';
cityareacode[47]='234';
cityareacode[48]='224';

cityareacode[49]='336';
cityareacode[50]='324';
cityareacode[51]='325';
cityareacode[52]='326';
cityareacode[53]='327';
cityareacode[54]='328';
cityareacode[55]='330';
cityareacode[56]='333';
cityareacode[57]='338';
cityareacode[58]='335';
cityareacode[59]='337';
cityareacode[60]='320';
cityareacode[61]='334';

cityareacode[62]='300';
cityareacode[63]='300';
cityareacode[64]='300';
cityareacode[65]='304';
cityareacode[66]='302';
cityareacode[67]='315';
cityareacode[68]='303';
cityareacode[69]='305';
cityareacode[70]='306';
cityareacode[71]='308';
cityareacode[72]='310';
cityareacode[73]='311';
cityareacode[74]='312';
cityareacode[75]='307';
cityareacode[76]='314';
cityareacode[77]='313';

cityareacode[78]='368';
cityareacode[79]='363';
cityareacode[80]='364';
cityareacode[81]='365';
cityareacode[82]='369';
cityareacode[83]='367';
cityareacode[84]='362';
cityareacode[85]='353';
cityareacode[86]='366';
cityareacode[87]='361';
cityareacode[88]='360';
cityareacode[89]='358';
cityareacode[90]='357';
cityareacode[91]='354';
cityareacode[92]='352';
cityareacode[93]='351';
cityareacode[94]='350';
cityareacode[95]='356';

cityareacode[96]='408';
cityareacode[97]='407';
cityareacode[98]='404';
cityareacode[99]='406';
cityareacode[100]='402';
cityareacode[101]='400';
cityareacode[102]='403';
cityareacode[103]='401';

cityareacode[104]='432';
cityareacode[105]='439';
cityareacode[106]='438';
cityareacode[107]='437';
cityareacode[108]='436';
cityareacode[109]='435';
cityareacode[110]='433';
cityareacode[111]='429';
cityareacode[112]='428';
cityareacode[113]='427';
cityareacode[114]='420';
cityareacode[115]='434';
cityareacode[116]='426';
cityareacode[117]='411';
cityareacode[118]='414';
cityareacode[119]='412';
cityareacode[120]='421';
cityareacode[121]='422';
cityareacode[122]='423';
cityareacode[123]='424';
cityareacode[124]='413';

cityareacode[125]='516';
cityareacode[126]='515';
cityareacode[127]='520';
cityareacode[128]='521';
cityareacode[129]='530';
cityareacode[130]='523';
cityareacode[131]='525';
cityareacode[132]='526';
cityareacode[133]='528';
cityareacode[134]='514';
cityareacode[135]='522';
cityareacode[136]='527';
cityareacode[137]='504';
cityareacode[138]='513';
cityareacode[139]='524';
cityareacode[140]='500';
cityareacode[141]='503';
cityareacode[142]='505';
cityareacode[143]='506';
cityareacode[144]='507';
cityareacode[145]='508';
cityareacode[146]='509';
cityareacode[147]='510';
cityareacode[148]='511';
cityareacode[149]='512';
cityareacode[150]='502';

cityareacode[151]='541';
cityareacode[152]='552';
cityareacode[153]='544';
cityareacode[154]='545';
cityareacode[155]='546';
cityareacode[156]='551';
cityareacode[157]='553';
cityareacode[158]='555';
cityareacode[159]='556';
cityareacode[160]='542';
cityareacode[161]='540';
cityareacode[162]='558';
cityareacode[163]='557';

cityareacode[164]='633';
cityareacode[165]='646';
cityareacode[166]='630';
cityareacode[167]='631';
cityareacode[168]='632';
cityareacode[169]='651';
cityareacode[170]='655';
cityareacode[171]='654';
cityareacode[172]='640';
cityareacode[173]='652';
cityareacode[174]='634';
cityareacode[175]='649';
cityareacode[176]='648';
cityareacode[177]='647';
cityareacode[178]='643';
cityareacode[179]='638';
cityareacode[180]='637';
cityareacode[181]='636';
cityareacode[182]='635';
cityareacode[183]='653';

cityareacode[184]='600';
cityareacode[185]='607';
cityareacode[186]='602';
cityareacode[187]='603';
cityareacode[188]='604';
cityareacode[189]='615';
cityareacode[190]='606';
cityareacode[191]='625';
cityareacode[192]='624';
cityareacode[193]='623';
cityareacode[194]='622';
cityareacode[195]='616';
cityareacode[196]='614';
cityareacode[197]='613';
cityareacode[198]='612';
cityareacode[199]='611';
cityareacode[200]='608';
cityareacode[201]='605';
cityareacode[202]='621';

cityareacode[203]='702';
cityareacode[204]='704';
cityareacode[205]='709';
cityareacode[206]='701';
cityareacode[207]='700';
cityareacode[208]='708';

cityareacode[209]='741';
cityareacode[210]='726';
cityareacode[211]='730';
cityareacode[212]='732';
cityareacode[213]='733';
cityareacode[214]='734';
cityareacode[215]='735';
cityareacode[216]='737';
cityareacode[217]='727';
cityareacode[218]='742';
cityareacode[219]='743';
cityareacode[220]='744';
cityareacode[221]='745';
cityareacode[222]='725';
cityareacode[223]='736';
cityareacode[224]='716';
cityareacode[225]='724';
cityareacode[226]='711';
cityareacode[227]='712';
cityareacode[228]='713';
cityareacode[229]='731';
cityareacode[230]='715';
cityareacode[231]='717';
cityareacode[232]='718';
cityareacode[233]='719';
cityareacode[234]='720';
cityareacode[235]='721';
cityareacode[236]='722';
cityareacode[237]='710';
cityareacode[238]='723';
cityareacode[239]='714';

cityareacode[240]='803';
cityareacode[241]='813';
cityareacode[242]='812';
cityareacode[243]='811';
cityareacode[244]='807';
cityareacode[245]='806';
cityareacode[246]='802';
cityareacode[247]='801';
cityareacode[248]='800';
cityareacode[249]='804';
cityareacode[250]='805';

cityareacode[251]='848';
cityareacode[252]='831';
cityareacode[253]='832';
cityareacode[254]='833';
cityareacode[255]='852';
cityareacode[256]='842';
cityareacode[257]='844';
cityareacode[258]='845';
cityareacode[259]='847';
cityareacode[260]='849';
cityareacode[261]='851';
cityareacode[262]='840';
cityareacode[263]='830';
cityareacode[264]='846';
cityareacode[265]='820';
cityareacode[266]='843';
cityareacode[267]='814';
cityareacode[268]='815';
cityareacode[269]='829';
cityareacode[270]='821';
cityareacode[271]='822';
cityareacode[272]='827';
cityareacode[273]='828';
cityareacode[274]='823';
cityareacode[275]='826';
cityareacode[276]='825';
cityareacode[277]='824';

cityareacode[278]='927';
cityareacode[279]='942';
cityareacode[280]='912';
cityareacode[281]='920';
cityareacode[282]='922';
cityareacode[283]='923';
cityareacode[284]='924';
cityareacode[285]='925';
cityareacode[286]='926';
cityareacode[287]='921';
cityareacode[288]='928';
cityareacode[289]='929';
cityareacode[290]='931';
cityareacode[291]='932';
cityareacode[292]='909';
cityareacode[293]='941';
cityareacode[294]='911';
cityareacode[295]='943';
cityareacode[296]='944';
cityareacode[297]='945';
cityareacode[298]='946';
cityareacode[299]='947';
cityareacode[300]='940';
cityareacode[301]='902';
cityareacode[302]='913';
cityareacode[303]='901';
cityareacode[304]='908';
cityareacode[305]='903';
cityareacode[306]='904';
cityareacode[307]='906';
cityareacode[308]='900';
cityareacode[309]='905';
cityareacode[310]='907';

cityareacode[311]='959';
cityareacode[312]='950';
cityareacode[313]='951';
cityareacode[314]='953';
cityareacode[315]='966';
cityareacode[316]='954';
cityareacode[317]='955';
cityareacode[318]='956';
cityareacode[319]='957';
cityareacode[320]='964';
cityareacode[321]='963';
cityareacode[322]='962';
cityareacode[323]='961';
cityareacode[324]='965';
cityareacode[325]='958';
cityareacode[326]='952';

cityareacode[327]='978';
cityareacode[328]='981';
cityareacode[329]='982';
cityareacode[330]='979';
cityareacode[331]='983';
cityareacode[332]='977';
cityareacode[333]='976';
cityareacode[334]='975';
cityareacode[335]='974';
cityareacode[336]='973';
cityareacode[337]='972';
cityareacode[338]='970';
cityareacode[339]='971';

cityareacode[340]='272';
cityareacode[341]='260';
cityareacode[342]='261';
cityareacode[343]='262';
cityareacode[344]='263';
cityareacode[345]='264';
cityareacode[346]='265';
cityareacode[347]='266';
cityareacode[348]='267';
cityareacode[349]='268';
cityareacode[350]='270';
cityareacode[351]='269';

cityareacode[352]='880';
cityareacode[353]='882';
cityareacode[354]='883';
cityareacode[355]='884';
cityareacode[356]='885';
cityareacode[357]='881';

cityareacode[358]='892';
cityareacode[359]='891';
cityareacode[360]='893';
cityareacode[361]='894';
cityareacode[362]='896';
cityareacode[363]='890';

cityareacode[364]='209';
cityareacode[365]='212';
cityareacode[366]='211';
cityareacode[367]='210';

cityareacode[368] = '819';
cityareacode[369] = '817';
cityareacode[370] = '290';

cityareacode[371] = '';

function citychange(form) {
	i = form.Area.selectedIndex + 1;
	form.cityarea.length = cityarea_account[i] - cityarea_account[i-1];
	index = cityarea_account[i-1] + 1;
	for (j = 0; j < form.cityarea.length; j ++) {
		form.cityarea.options[j].value = cityarea[index + j];
		form.cityarea.options[j].text = cityarea[index + j];
	}
	form.Mcode.value = cityareacode[cityarea_account[i-1]+1];
	form.cuszip.value = cityareacode[cityarea_account[i-1]+1];
	form.cityarea.options[0].selected = true;
	i = form.cityarea.selectedIndex;
	form.cusadr.value = form.Area.options[form.Area.selectedIndex].value+form.cityarea.options[form.cityarea.selectedIndex].value;
}
function areachange(form) {
	i = form.cityarea.selectedIndex;
	form.Mcode.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
	form.cuszip.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
	form.cusadr.value = form.Area.options[form.Area.selectedIndex].value+form.cityarea.options[form.cityarea.selectedIndex].value;
}

function citychange2(form) {
	i = form.Area2.selectedIndex + 1;
	form.cityarea2.length = cityarea_account[i] - cityarea_account[i-1];
	index = cityarea_account[i-1] + 1;
	for (j = 0; j < form.cityarea2.length; j ++) {
		form.cityarea2.options[j].value = cityarea[index + j];
		form.cityarea2.options[j].text = cityarea[index + j];
	}
	form.Mcode2.value = cityareacode[cityarea_account[i-1]+1];
	form.cuszip2.value = cityareacode[cityarea_account[i-1]+1];
	form.cityarea2.options[0].selected = true;
	i = form.cityarea2.selectedIndex;
	form.cusadr2.value = form.Area2.options[form.Area2.selectedIndex].value+form.cityarea2.options[form.cityarea2.selectedIndex].value;
}
function areachange2(form) {
	i = form.cityarea2.selectedIndex;
	form.Mcode2.value = cityareacode[cityarea_account[form.Area2.selectedIndex]+i+1];
	form.cuszip2.value = cityareacode[cityarea_account[form.Area2.selectedIndex]+i+1];
	form.cusadr2.value = form.Area2.options[form.Area2.selectedIndex].value+form.cityarea2.options[form.cityarea2.selectedIndex].value;
}