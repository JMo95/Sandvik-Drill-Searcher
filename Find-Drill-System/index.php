<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP| MySQL | React.js | Axios Example</title>
    <script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
    <!-- Load Babel Compiler -->
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
<div id='root' class='container'></div>

<script  type="text/babel">



class App extends React.Component {
  state = {
    CurrentID: 0,
    ToggleEditing: 0,
    Username: "",
    Password: "",
    LoggedIn: 0,
    LoginButtonOff: false,
    ErrorAddedBadChar: false,
    BadChar: "",
    ctacts: [],
    contacts: [],
    LabelNames: [],
    InputsForLabels: [],
    InputResults: [],
    ElementArray: [],
    DrillResult: 0,
    ParsedDrills: [],
    ChosenDrill: 0,
    ToggleEditing: 0,
    ShowSearcher: 0,
    HoleDiameter: "",
    HoleDepth: "",
    HoleSize: "",
    Elevation: "",
    UCSu: "",
    CurrPenRate: "",
    MeterDrilled: "",
    TargetProdH: "",
    Pulldown: "",
    RPMu: "",
    AirFactor: "",
    CurrentWorkingHammers: [],
    ChosenPipeSize: 0,
    RotChoice: 0,
    HaveSearched: 0,
    RotBitChoice: 0,
    ChosenHammerType: 0,
    HammerBitChoice: 0,
    DTHChoice: 0,
    PrefDrillType: 0,
    PrintingPage: 0,
    HoleSize_Millimeters: 0,
    Input_Target: 0,
    ShowRotary: true,
    ShowDTH: true,
  }
        
    
        
 MaptoInt(Input)
 {
     if(Input == 'a')
     { return 0 }
     else if(Input == 'b')
     { return 1 }
     else if(Input == 'c')
     { return 2 }
     else if(Input == 'd')
     { return 3 }
     else if(Input == 'e')
     { return 4 }
     else if(Input == 'f')
     { return 5 }
     else if(Input == 'g')
     { return 6 }
     else if(Input == 'h')
     { return 7 }
     else if(Input == 'i')
     { return 8 }
     else if(Input == 'j')
     { return 9 }
     else if(Input == 'k')
     { return 0 }
     else if(Input == 'l')
     { return 1 }
     else if(Input == 'm')
     { return 2 }
     else if(Input == 'n')
     { return 3 }
     else if(Input == 'o')
     { return 4 }
     else if(Input == 'p')
     { return 5 }
     else if(Input == 'q')
     { return 6 }
     else if(Input == 'r')
     { return 7 }
     else if(Input == 's')
     { return 8 }
     else if(Input == 't')
     { return 9 }
     else if(Input == 'u')
     { return 0 }
     else if(Input == 'v')
     { return 1 }
     else if(Input == 'w')
     { return 2 }
     else if(Input == 'x')
     { return 3 }
     else if(Input == 'y')
     { return 4 }
     else if(Input == 'z')
     { return 5 }
 }
        
 componentDidMount() {
    const url = 'api/ctacts.php?inputone=ax5&inputtwo=by715'
    axios.get(url).then(response => response.data)
    .then((data) => {
      //First we need to decrypt the data. It's a list of usernames and passwords starting with username first, then password, then next username, and so on. We're going to convert it into a json of such data after decrypting each.
      var ListSetup = [];
      var DatParser = 1;
      var CurrentInput = "";
      while (data[DatParser] != ']')
      {
          CurrentInput = CurrentInput + data[DatParser];
          DatParser++;
          if(data[DatParser] == ',')
          {
              ListSetup.push(CurrentInput);
              CurrentInput = "";
              DatParser++;
          }
          if(data[DatParser] == ']')
          {
              ListSetup.push(CurrentInput);
              CurrentInput = "";
          }
      }
      var JsonData = [];
      var Parser = 0;
      while (Parser < ListSetup.length)
      {
          //First we get the first username.
          var CUser = ListSetup[Parser];
          var UserDec = "";
          //Now we're going to parse through taht.
          var UParser = 0;
          while (UParser < CUser.length)
          {
              //Take the first input, that tells us how much we need to read to get the code for the first letter.
              var LetLen = CUser[UParser];
              UParser++;
              //Now we need to parse forward that many times.
              var InnerParser = 0;
              var CLetter = "";
              while (InnerParser < LetLen)
              {
                  CLetter = CLetter + CUser[UParser];
                  UParser++;
                  InnerParser++;
              }
              //Now we have our first letter, now we need to decrypt it based on whether the next input is a # (for a lowercase letter), a u (for an uppercase letter), an n (for a number), or an s (for a special digit)
              //First lets check for uppercase letter.
              if (CLetter[0] == 'u')
              {
                  //Now we first remove that extra letter u.
                  CLetter = CLetter.substring(1);
                  //Then convert it to an integer
                  CLetter = parseInt(CLetter);
                  //Divide it by 12
                  CLetter = CLetter / 12;
                  //Convert it to its letter equivalent.
                  CLetter = String.fromCharCode(65 + CLetter - 1);
                  CLetter = CLetter.toUpperCase();
              }
              //Next check for a number
              else if (CLetter[0] == 'n')
              {
                  //In this case we just convert it from the letter 
                  CLetter = this.MaptoInt(CLetter[1]);
              }
              //Next check for a special case.
              else if (CLetter[0] == 's')
              {
                  //No conversion occurred, just take the special letter.
                  CLetter = CLetter[1];
              }
              //In all other cases it's a lowercase letter, repeat the 'u' process but convert it to lowercase afterward.
              else
              {
                  //convert it to an integer
                  CLetter = parseInt(CLetter);
                  //Divide it by 12
                  CLetter = CLetter / 12;
                  //Convert it to its letter equivalent.
                  CLetter = String.fromCharCode(65 + CLetter - 1);
                  //Send to lower case.
                  CLetter = CLetter.toLowerCase();
                  
              }
              //After all of that we have our current letter. Add it to UserDec and repeat.
              UserDec = UserDec + CLetter;
          }
          Parser++;
          //Now we get the password
          var CPass = ListSetup[Parser];
          var PassDec = "";
          //Now we're going to parse through taht.
          var PParser = 0;
          while (PParser < CPass.length)
          {
              //Take the first input, that tells us how much we need to read to get the code for the first letter.
              var LetLen = CPass[PParser];
              PParser++;
              //Now we need to parse forward that many times.
              var InnerParser = 0;
              var CLetter = "";
              while (InnerParser < LetLen)
              {
                  CLetter = CLetter + CPass[PParser];
                  PParser++;
                  InnerParser++;
              }
              //Now we have our first letter, now we need to decrypt it based on whether the next input is a # (for a lowercase letter), a u (for an uppercase letter), an n (for a number), or an s (for a special digit)
              //First lets check for uppercase letter.
              if (CLetter[0] == 'u')
              {
                  //Now we first remove that extra letter u.
                  CLetter = CLetter.substring(1);
                  //Then convert it to an integer
                  CLetter = parseInt(CLetter);
                  //Divide it by 12
                  CLetter = CLetter / 12;
                  //Convert it to its letter equivalent.
                  CLetter = String.fromCharCode(65 + CLetter - 1);
                  CLetter = CLetter.toUpperCase();
              }
              //Next check for a number
              else if (CLetter[0] == 'n')
              {
                  //In this case we just convert it from the letter 
                  CLetter = this.MaptoInt(CLetter[1]);
              }
              //Next check for a special case.
              else if (CLetter[0] == 's')
              {
                  //No conversion occurred, just take the special letter.
                  CLetter = CLetter[1];
              }
              //In all other cases it's a lowercase letter, repeat the 'u' process but convert it to lowercase afterward.
              else
              {
                  //convert it to an integer
                  CLetter = parseInt(CLetter);
                  //Divide it by 12
                  CLetter = CLetter / 12;
                  //Convert it to its letter equivalent.
                  CLetter = String.fromCharCode(65 + CLetter - 1);
                  //Send to lower case.
                  CLetter = CLetter.toLowerCase();
              
              }
              //After all of that we have our current letter. Add it to UserDec and repeat.
              PassDec = PassDec + CLetter;
          }
          Parser++;
          //Now we have the username and password, create a Json of it and add it to the list.
          var CurrAcc = { 'username': UserDec, 'password': PassDec }
          JsonData.push(CurrAcc);
      }
      this.setState({ ctacts: JsonData, })
     })
     
    //The Find Drill Parser component 
    const url2 = '/sandvik-drill-parser/api/contacts.php'
    axios.get(url2).then(response => response.data)
    .then((data) => {
      this.setState({ 
          contacts: data, 
          ParsedDrills: data,
      })
      let Labels = [];
      let NewContacts = [];
      {
      for (var J in this.state.contacts[0])
      { 
        Labels.push(J);
      }
      for (var Rig in this.state.contacts)
      {
          var NewContact = this.state.contacts
          for (var RigElement in this.state.contacts[Rig])
          {
              var CurrentData = this.state.contacts[Rig][RigElement]
              if (CurrentData != null)
              {
                var DataList = []
                //Parse through the string and add an element every time you reach a comma.
                var Parser = 0
                var CurrentInput = ""
                while (Parser < CurrentData.length)
                {
                    CurrentInput = CurrentInput + CurrentData[Parser]
                    Parser = Parser + 1
                    if (CurrentData[Parser] == ',')
                    {
                        DataList.push(CurrentInput)
                        CurrentInput = ""
                        Parser = Parser + 1
                    }
                    if (Parser == CurrentData.length)
                    {
                        DataList.push(CurrentInput)
                        CurrentInput = ""
                    }
                }
                if (DataList.length > 1)
                {
                    NewContact[Rig][RigElement] = DataList
                }
                  else
                { 
                    NewContact[Rig][RigElement] = CurrentData
                }
              }
              else
              {
                  NewContact[Rig][RigElement] = CurrentData
              }
          }
          NewContacts.push(NewContact)
      }
      }
      this.setState({ contacts: NewContacts[0], });
      this.setState({ LabelNames: Labels, });
     })
     //For debugging: setting default values of inputs
     this.setState({
        HoleDiameter: 203,
        HoleDepth: 15,
        HoleSize: 8,
        HoleSize_Millimeters: 203,
        Elevation: 4621,
        UCSu: 60,
        CurrPenRate: 200,
        MeterDrilled: 10000,
        TargetProdH: 50,
        Pulldown: 3000,
        RPMu: 160,
        AirFactor: 1
     })
  }
        
 Change_Username = (e) =>
 {
     var BadInput = "";
     if(e.target.value[e.target.value.length - 1] === "'")
     { BadInput = e.target.value[e.target.value.length - 1]; }
     if(!(BadInput == ""))
     {
         e.target.value.replace(BadInput, '');
         this.setState({
             ErrorAddedBadChar: true,
             BadChar: BadInput,
         })
     }
     else
     {
        this.setState({
            Username: e.target.value,
            ErrorAddedBadChar: false,
        });
     }
 }
 
 Change_Password = (e) =>
 {
     var BadInput = "";
     if(e.target.value[e.target.value.length - 1] === "'")
     { BadInput = e.target.value[e.target.value.length - 1]; }
     if(!(BadInput == ""))
     {
         e.target.value.replace(BadInput, '');
         this.setState({
             ErrorAddedBadChar: true,
             BadChar: BadInput,
         })
     }
     else
     {
        this.setState({
            Password: e.target.value,
            ErrorAddedBadChar: false,
        });    
     }
 }
 
 sleep = (milliseconds) => {
     return new Promise(resolve => setTimeout(resolve, milliseconds));
 }
 
 Login = (e) =>
 {
    var Parser = 0
    var SuccessfulLogin = false
    while (Parser < this.state.ctacts.length)
    {
        if(this.state.ctacts[Parser]['username'] == this.state.Username && this.state.ctacts[Parser]['password'] == this.state.Password)
        {
            SuccessfulLogin = true;
        }
        Parser += 1
    }
    if (SuccessfulLogin)
    {
        this.setState({
            LoggedIn: 1,
            ErrorAddedBadChar: false,
            LoginButtonOff: false,
        })
    }
 }
 
 Logout = (e) =>
 {
     this.setState({
         LoggedIn: 0,
     })
 }
 
 Create_Account_Page = (e) =>
 {
     this.setState({
         LoggedIn: 2,
     })
 }
 
 Create_Account = (e) =>
 {
    if(this.state.Username.length != 0 && this.state.Password.length != 0)
    {
        let formData = new FormData();
        //First we append 0 to $_POST[0] so we know we're creating a new account.
        formData.append(0, 0);
        //Then we append the username to $_POST[1].
        formData.append(1, this.state.Username);
        //Then we append the password to $_POST[2].
        formData.append(2, this.state.Password);
        axios({
            method: 'post',
            url: 'api/ctacts.php',
            data: formData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
        })  
        .then(function (response) {
            //handle success
            console.log(response)
        })
        .catch(function (response) {
            //handle error
            console.log(response)
        }); 
        let formDataNew = new FormData();
        //First we append 0 to $_POST[0] so we know we're creating a new account.
        formDataNew.append(0, 1);
        //Then we append the username to $_POST[1].
        formDataNew.append(1, '');
        //Then we append the password to $_POST[2].
        formDataNew.append(2, '');
        axios({
            method: 'post',
            url: 'api/ctacts.php',
            data: formData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
        })  
        .then(function (response) {
            //handle success
            console.log(response)
        })
        .catch(function (response) {
            //handle error
            console.log(response)
        });
    }
 }
 
 Return()
 {
     this.setState({
         DrillResult: 0,
     })
 }
  
 Toggle_Editing()
 {
    if (this.state.ToggleEditing == 0)
    {
        this.setState({
            ToggleEditing: 1,
        })
    }
    else
    {
        this.setState({
            ToggleEditing: 0,
        })
    }
 }
        
 Input_Label(Index, LabelList) 
 {
     var Parser = Index;
     var InputArray = this.state.InputsForLabels;
     while (InputArray.length < Index - 1)
     {
         InputArray.push([]);
     }
     InputArray[Index] = LabelList;
     this.setState({
         InputsForLabels: InputArray,
     })
 };
        
  Change_Input = (e) =>
  {
      var Index = e.target.id;
      var InputArray = this.state.InputResults;
      while (InputArray.length <= Index)
      {
          InputArray.push("");
      }
      InputArray[Index] = e.target.value;
      this.setState({
          InputResults: InputArray,
      })
  };

  Change_Element = (e) =>
  {
      var Index = e.target.id;
      var InputArray = this.state.ElementArray;
      while (InputArray.length <= Index)
      {
          InputArray.push("");
      }
      InputArray[Index] = e.target.value;
      this.setState({
          ElementArray: InputArray,
      })
  }
  
  Drill_Search = (e) =>
  {
      this.setState({
          ShowRotary: true,
          ShowDTH: true,
      })
      //Once this button is it we assume taht the use has set up the inputs to their liking, therefore
      //InputResults = all of the inputs that are desired, where InputResults[k] equates to LabelNames[k + 1] to account for the hidden LabelName[0] = "drill_id"
      //contacts contains the list of all of the drills, which we'll parse through to create our ParsedDrills list.
      var pipStoW = { "89": 512, 
                      "102": 512,
                      "114": 800,
                      "127": 1100,
                      "140": 1600,
                      "152": 1381, 
                      "165": 1590, 
                      "178": 2400, 
                      "179": 2720, 
                      "194": 2713, 
                      "203": 1675, 
                      "219": 3684,
                      "229": 1961, 
                      "244": 3000, 
                      "254": 3245, 
                      "260": 4300, 
                      "273": 3550, 
                      "324": 4000 }
    var Hammers = { "M30" : [60, 90, [102, 114, 121, 127, 130, 133, 140]],
                    "M40" : [64, 115, [127, 130, 133, 140, 143, 146, 152]],
                    "M50" : [61, 140, [140, 143, 146, 152, 156, 159, 165, 171]],
                    "M60" : [68, 165, [152, 156, 159, 165, 171, 178, 191, 203]],
                    "M80" : [44, 203, [203, 216, 225, 241, 254, 270]]
    }
    var WorkingHammCombo = [];
    var AirFactors = [0.46, 1, 1.465];
    var DTHworks = false;
    var RockDRI = 48;
    for (var a in Hammers)
    {
        var CurrentCombo = [];
        CurrentCombo.push(a);
        for(var hammerIndex in Hammers[a][2])
        {
            //A new condition we need to add for the current hammer bit to be accepted is it is within five millimeters of the inputted desired bit.
            if(Math.abs(Hammers[a][2][hammerIndex] - this.state.HoleSize_Millimeters) > 20)
            {
                continue;
            }
            var AdjustedHammerROP = Hammers[a][0] * Math.pow(Hammers[a][1] / Hammers[a][2][hammerIndex], 1.5);             
            var RDI = AdjustedHammerROP * this.state.AirFactor;
            var ROP = [];
            var counter = 0;
            while(counter < 26)
            {
                var DI = counter * 2 + 30;
                var ROPs = RDI * Math.pow((DI / RockDRI), 1.8) * 1.15;
                ROP.push(ROPs);
                counter++;
            }
            var Total = 0;
            var InstanteousROP;
            if(this.state.UCSu < 100 && this.state.UCSu >= 0)
            {
                var InnerParser = 19;
                while(InnerParser < 26)
                {
                    Total += ROP[InnerParser];
                    InnerParser++;
                }
                InstanteousROP = Total / 7;
            }
            else if(this.state.UCSu >= 100 && this.state.UCSu < 200)
            {
                var InnerParser = 12;
                while(InnerParser < 19)
                {
                    Total += ROP[InnerParser];
                    InnerParser++;
                }
                InstanteousROP = Total / 7;
            }
            else if(this.state.UCSu >= 200 && this.state.UCSu < 300)
            {
                var InnerParser = 6;
                while(InnerParser < 12)
                {
                    Total += ROP[InnerParser];
                    InnerParser++;
                }
                InstanteousROP = Total / 6;
            }
            else if(this.state.UCSu >= 300)
            {
                var InnerParser = 0;
                while(InnerParser < 6)
                {
                    Total += ROP[InnerParser];
                    InnerParser++;
                }
                InstanteousROP = Total / 6;
            }
            if(InstanteousROP >= this.state.CurrPenRate && (InstanteousROP * this.state.TargetProdH >= this.state.MeterDrilled))
            {
                DTHworks = true;
                CurrentCombo.push(Hammers[a][2][hammerIndex]);
            }

        }
        WorkingHammCombo.push(CurrentCombo);
    }
    this.setState({
        CurrentWorkingHammers: WorkingHammCombo,
                })  
    
      var FilteredData = [];
      var Parser = 1;
      while (Parser < this.state.contacts.length)
      {
          var CanDrillHole = true;
          var WorkingRotaryComps = []
          var InnerParser = 1;
          var AddElement = true;
          var CurrentRig = this.state.contacts[Parser];
          /*This is the section for the diameter of hole*/
          
         
          var minHoleSz =  CurrentRig['Hole Size Diameter'][0];
          var maxHoleSz = CurrentRig['Hole Size Diameter'][1];
          
          if(this.state.HoleDiameter < minHoleSz || this.state.HoleDiameter > maxHoleSz)
          { 
              AddElement = false; 
              CanDrillHole = false;
          }
          /*This is the section for the hole depth*/ /*TooDeep = PipeCount*/
          var TooDeep = this.state.HoleDepth / 0.3 - CurrentRig['Single Pass'] - (CurrentRig['Pipe Length'] * CurrentRig['Loader Cap']);
          var AddedPipe;
          if (TooDeep > 0)
          { AddElement = false; }
          else
          {
            AddedPipe = ((this.state.HoleDepth / 0.3) - CurrentRig['Single Pass']) / CurrentRig['Pipe Length'];
            if (AddedPipe < 0)
            {
                AddedPipe *= -1;
                AddedPipe = Math.ceil(AddedPipe);
                AddedPipe *= -1;
            }
            else
                AddedPipe = Math.ceil(AddedPipe);
          }
          
          /*Est Weight on Bit (BitWeight in kN) */ /*NOTE MAP OBJECT was used for Pipe Sizes to Weight */
          var BitWeight;
          var AdjustedWOB;
         /* if(CurrentRig['DTH/Rotary'] != "DTH")
          {
            if(TooDeep > 0)
                AdjustedWOB = (CurrentRig['RH Weight'] + pipeSztoWeight.get(CurrentRig['Pipe Sizes']) * CurrentRig['Loader Cap'] + (CurrentRig['Rotary Max Pulldown'] / CurrentRig['Max Feed Pressure']) * this.state.Pulldown);
            else
            {
                if (AddedPipe < 1)
                    AdjustedWOB = (CurrentRig['RH Weight'] + pipeSztoWeight.get(CurrentRig['Pipe Sizes']) + (CurrentRig['Rotary Max Pulldown'] / CurrentRig['Max Feed Pressure']) * this.state.Pulldown);
                else
                    AdjustedWOB = (CurrentRig['RH Weight'] + pipeSztoWeight.get(CurrentRig['Pipe Sizes']) * (AddedPipe + 1) + (CurrentRig['Rotary Max Pulldown'] / CurrentRig['Max Feed Pressure']) * this.state.Pulldown);
            }
            //AU10 == True BigWeight. This has not been written in due to unknown nature of AU10
          }*/
          //Instant Penetration: NOTE ONly need this for Current Pen Rate Comparison
          var CorrectCombinations = [];
          var WorkingDTHComps = [];
          if(CurrentRig['DTH/Rotary'] != "DTH")
          {
            var Temp;
            var PenetrationRateRotary;
            if(TooDeep > 0)
            {
                for(var i = 0; i < CurrentRig['Pipe Sizes'].length; i++)
                {
                    var PipeSizeworks = false;
                    var listCheese = CurrentRig['Rotary Comp'];
                    var WorkingPipeCompCombo = []
                    WorkingPipeCompCombo.push(CurrentRig['Pipe Sizes'][i])
                    if(typeof(listCheese) != typeof([]))
                    {
                        var emptyList = [];
                        emptyList.push(listCheese);
                        listCheese = emptyList;
                    }
                    for(var k = 0; k < listCheese.length; k++)
                    {
                        var RodDiameter = CurrentRig['Pipe Sizes'][i] / 25.4;
                            
                        var AltiAmbiPres = 14.7 * Math.pow((1 - this.state.Elevation * 0.0000069), 5.25588);
                        
                        for(var m = 0; m < CurrentRig['Rotary Bit (in)'].length; m++)
                        {
                                
                        var HoleDiam = CurrentRig['Rotary Bit (in)'][m] / 25.4;
                            
                        var CompVolume = listCheese[k];
                            
                        var CompActVolAlt = CompVolume * CompVolume / (14.7 * (CompVolume / AltiAmbiPres));
                           
                        var UHVMax = CompActVolAlt * 183.5 / (HoleDiam * HoleDiam - RodDiameter * RodDiameter);
                    
                        if(UHVMax > 3000 && UHVMax < 10000)
                        {
                            PipeSizeworks = true;
                            var WorkingPipeSetup = []
                            WorkingPipeSetup.push(listCheese[k])
                            WorkingPipeSetup.push(CurrentRig['Rotary Bit (in)'][m])
                            WorkingPipeCompCombo.push(WorkingPipeSetup)
                        }
                            
                        }
                    
                    }
                    if (PipeSizeworks == false)
                    {
                        continue;
                    }
                    else
                    {
                        WorkingRotaryComps.push(WorkingPipeCompCombo)
                    }
                    for(var j = 0; j < CurrentRig['Rotary Bit (in)'].length; j++)
                    {
                        //We need to add a new check to each bit: that it's within a certain range in millimeters of the inputted desired bitrange. I'll say within five. So if the difference between this bit and the inputted one is greater than five, go next.
                        if(Math.abs(parseInt(CurrentRig['Rotary Bit (in)']) - this.state.HoleSize_Millimeters) > 20)
                        { continue; }
                        if(pipStoW[CurrentRig['Pipe Sizes'][i]] == undefined)
                                continue;
                        Temp = (parseInt(CurrentRig['RH Weight']) + pipStoW[CurrentRig['Pipe Sizes'][i]] * CurrentRig['Loader Cap'] + (CurrentRig['Rotary Max Pulldown'] / CurrentRig['Max Feed Pressure']) * this.state.Pulldown);
                        PenetrationRateRotary = (2.18 * Temp * this.state.RPMu) / (0.2 * (this.state.UCSu / 0.00689457) * Math.pow((CurrentRig['Rotary Bit (in)'][j] / 25.4), 0.9) * (this.state.UCSu / 68.9457)) / (3.28083);
                        if(PenetrationRateRotary >= this.state.CurrPenRate && (PenetrationRateRotary * this.state.TargetProdH >= this.state.MeterDrilled))
                        {
                            var CurrPipeSz = CurrentRig['Pipe Sizes'][i];
                            var CurrRotBit = CurrentRig['Rotary Bit (in)'][j];
                            var CurrentCombination = [];
                            CurrentCombination.push(CurrPipeSz);
                            CurrentCombination.push(CurrRotBit);
                            CorrectCombinations.push(CurrentCombination);
                        }
                    }
                }
            }
            else
            {
                if (AddedPipe < 1)
                {
                    for(var i = 0; i < CurrentRig['Pipe Sizes'].length; i++)
                    {
                        var PipeSizeworks = false;
                        var listCheese = CurrentRig['Rotary Comp'];
                        var WorkingPipeCompCombo = []
                        WorkingPipeCompCombo.push(CurrentRig['Pipe Sizes'][i])
                        if(typeof(listCheese) != typeof([]))
                        {
                            var emptyList = [];
                            emptyList.push(listCheese);
                            listCheese = emptyList;
                        }
                        for(var k = 0; k < listCheese.length; k++)
                        {                            
                            var RodDiameter = CurrentRig['Pipe Sizes'][i] / 25.4;
                            
                            var AltiAmbiPres = 14.7 * Math.pow((1 - this.state.Elevation * 0.0000069), 5.25588);
                            
                            for(var m = 0; m < CurrentRig['Rotary Bit (in)'].length; m++)
                            {
                                
                            var HoleDiam = CurrentRig['Rotary Bit (in)'][m] / 25.4;
                            
                            var CompVolume = listCheese[k];
                            
                            var CompActVolAlt = CompVolume * CompVolume / (14.7 * (CompVolume / AltiAmbiPres));
                           
                            var UHVMax = CompActVolAlt * 183.5 / (HoleDiam * HoleDiam - RodDiameter * RodDiameter);
                    
                            if(UHVMax > 3000 && UHVMax < 10000)
                            {
                                PipeSizeworks = true;
                                var WorkingPipeSetup = []
                                WorkingPipeSetup.push(listCheese[k])
                                WorkingPipeSetup.push(CurrentRig['Rotary Bit (in)'][m])
                                WorkingPipeCompCombo.push(WorkingPipeSetup)
                            }
                                
                            }
                       
                        }
                        if (PipeSizeworks == false)
                        {
                            continue;
                        }
                        else
                        {
                            WorkingRotaryComps.push(WorkingPipeCompCombo)
                        }
                        for(var j = 0; j < CurrentRig['Rotary Bit (in)'].length; j++)
                        {
                            //We need to add a new check to each bit: that it's within a certain range in millimeters of the inputted desired bitrange. I'll say within five. So if the difference between this bit and the inputted one is greater than five, go next.
                            if(Math.abs(parseInt(CurrentRig['Rotary Bit (in)']) - this.state.HoleSize_Millimeters) > 20)
                            { continue; }
                            if(pipStoW[CurrentRig['Pipe Sizes'][i]] == undefined)
                                continue;
                            Temp = parseInt(CurrentRig['RH Weight']) + pipStoW[CurrentRig['Pipe Sizes'][i]] + (CurrentRig['Rotary Max Pulldown'] / CurrentRig['Max Feed Pressure']) * this.state.Pulldown;
                            PenetrationRateRotary = (2.18 * Temp * this.state.RPMu) / (0.2 * (this.state.UCSu / 0.00689457) * Math.pow((CurrentRig['Rotary Bit (in)'][j] / 25.4), 0.9) * (this.state.UCSu / 68.9457)) / (3.28083);
                            if(PenetrationRateRotary >= this.state.CurrPenRate && (PenetrationRateRotary * this.state.TargetProdH >= this.state.MeterDrilled))
                            {
                                var CurrPipeSz = CurrentRig['Pipe Sizes'][i];
                                var CurrRotBit = CurrentRig['Rotary Bit (in)'][j];
                                var CurrentCombination = [];
                                CurrentCombination.push(CurrPipeSz);
                                CurrentCombination.push(CurrRotBit);
                                CorrectCombinations.push(CurrentCombination);
                            }
                        }
                    }
                }   
                else
                {
                    for(var i = 0; i < CurrentRig['Pipe Sizes'].length; i++)
                    {
                        var PipeSizeworks = false;
                        var listCheese = CurrentRig['Rotary Comp'];
                        var WorkingPipeCompCombo = []
                        WorkingPipeCompCombo.push(CurrentRig['Pipe Sizes'][i])
                        if(typeof(listCheese) != typeof([]))
                        {
                            var emptyList = [];
                            emptyList.push(listCheese);
                            listCheese = emptyList;
                        }
                        for(var k = 0; k < listCheese.length; k++)
                        {
                            var RodDiameter = CurrentRig['Pipe Sizes'][i] / 25.4;
                            
                            var AltiAmbiPres = 14.7 * Math.pow((1 - this.state.Elevation * 0.0000069), 5.25588);
                            
                            for(var m = 0; m < CurrentRig['Rotary Bit (in)'].length; m++)
                            {
                                
                            var HoleDiam = CurrentRig['Rotary Bit (in)'][m] / 25.4;
                            
                            var CompVolume = listCheese[k];
                            
                            var CompActVolAlt = CompVolume * CompVolume / (14.7 * (CompVolume / AltiAmbiPres));
                           
                            var UHVMax = CompActVolAlt * 183.5 / (HoleDiam * HoleDiam - RodDiameter * RodDiameter);
                    
                            if(UHVMax > 3000 && UHVMax < 10000)
                            {
                                PipeSizeworks = true;
                                var WorkingPipeSetup = []
                                WorkingPipeSetup.push(listCheese[k])
                                WorkingPipeSetup.push(CurrentRig['Rotary Bit (in)'][m])
                                WorkingPipeCompCombo.push(WorkingPipeSetup)
                            }
                                
                            }
                       
                        }
                        if (PipeSizeworks == false)
                        {
                            continue;
                        }
                        else
                        {
                            WorkingRotaryComps.push(WorkingPipeCompCombo)
                        }
                        for(var j = 0; j < CurrentRig['Rotary Bit (in)'].length; j++)
                        {
                            //We need to add a new check to each bit: that it's within a certain range in millimeters of the inputted desired bitrange. I'll say within five. So if the difference between this bit and the inputted one is greater than five, go next.
                            if(Math.abs(parseInt(CurrentRig['Rotary Bit (in)'][j]) - this.state.HoleSize_Millimeters) > 20)
                            { continue; }
                            if(pipStoW[CurrentRig['Pipe Sizes'][i]] == undefined)
                                continue;
                            Temp = (parseInt(CurrentRig['RH Weight']) + pipStoW[CurrentRig['Pipe Sizes'][i]] * (AddedPipe + 1) + (CurrentRig['Rotary Max Pulldown'] / CurrentRig['Max Feed Pressure']) * this.state.Pulldown);
  
                            PenetrationRateRotary = (2.18 * Temp * this.state.RPMu) / (0.2 * (this.state.UCSu / 0.00689457) * Math.pow((CurrentRig['Rotary Bit (in)'][j] / 25.4), 0.9) * (this.state.UCSu / 68.9457)) / (3.28083);
                            if(PenetrationRateRotary >= this.state.CurrPenRate && (PenetrationRateRotary * this.state.TargetProdH >= this.state.MeterDrilled))
                            {
                                var CurrPipeSz = CurrentRig['Pipe Sizes'][i];
                                var CurrRotBit = CurrentRig['Rotary Bit (in)'][j];
                                var CurrentCombination = [];
                                CurrentCombination.push(CurrPipeSz);
                                CurrentCombination.push(CurrRotBit);
                                CorrectCombinations.push(CurrentCombination);
                            }
                        }
                    }
                }
                    
            }
          }
          var DTHGood = false;
          if(CurrentRig['DTH/Rotary'] != "Rotary")
          {
            
                if (TooDeep <= 0 && DTHworks)
                {
                    //Now before we confirm that DTH is good we need to check that for at least one Rig DTH compression and Rig Pie size
                    //for the given elevation and bit the HPComp is within 3000 and 10000 (not inclusive).
                    for(var i = 0; i < CurrentRig['Pipe Sizes'].length; i++)
                    {
                        var PipeCompCombination = []
                        PipeCompCombination.push(CurrentRig['Pipe Sizes'][i])
                        var PipeSizeworks = false;
                        var listCheese = CurrentRig['DTH HP Comp'];
                        if(typeof(listCheese) != typeof([]))
                        {
                            var emptyList = [];
                            emptyList.push(listCheese);
                            listCheese = emptyList;
                        }
                        for(var k = 0; k < listCheese.length; k++)
                        {
                            var RodDiameter = CurrentRig['Pipe Sizes'][i] / 25.4;
                            
                            var AltiAmbiPres = 14.7 - this.state.Elevation * 0.0004;
                            
                            var CompVolume = listCheese[k];
                            
                            var CompActVolAlt = CompVolume * CompVolume / (14.7 * (CompVolume / AltiAmbiPres));
                            
                            var WorkingBits = [];
                            for (var a in Hammers)
                            {
                                var CurrentCombo = [];
                                CurrentCombo.push(a);
                                for(var hammerIndex in Hammers[a][2])
                                {
                                    var BitSizeIn = Hammers[a][2][hammerIndex] / 25.4;
                                    var UHVMax = CompActVolAlt * 183.5 / (BitSizeIn * BitSizeIn - RodDiameter * RodDiameter)
                                    if(UHVMax > 3000 && UHVMax < 10000)
                                    {
                                        //First check if it's already in here.
                                        var Checker = 0;
                                        var NotInYet = true;
                                        while (Checker < WorkingBits.length)
                                        {
                                            if(WorkingBits[Checker] == Hammers[a][2][hammerIndex])
                                            { NotInYet = false; }
                                            Checker++;
                                        }
                                        if(NotInYet)
                                        { 
                                            WorkingBits.push(Hammers[a][2][hammerIndex]) 
                                        }
                                    }
                                }
                            }
                            if(WorkingBits.length > 0)
                            {
                                PipeSizeworks = true;
                                PipeCompCombination.push(listCheese[k]);
                                PipeCompCombination.push(WorkingBits);
                            }
                       
                        }
                        if (PipeSizeworks == false)
                        {
                            continue;
                        }
                        else
                        {
                            WorkingDTHComps.push(PipeCompCombination);
                        }
                        
                    }
                    if(WorkingDTHComps.length > 0)
                    {
                        //If for at least ONE pipe size and DTH Compression combination the UHVMax is between 3000 and 10000, then DTH is an option
                        //so we set DTHGood to true.
                        DTHGood = true;
                    }
                }
          }
          if (CorrectCombinations.length === 0)
          {
              AddElement = false;
          }
            if((((AddElement) && (this.state.PrefDrillType != 'DTH')) || ((DTHGood) && (this.state.PrefDrillType != 'Rotary'))) && (CanDrillHole))
            {
                if(this.state.PrefDrillType == 'Rotary')
                { DTHGood = false }
                if(this.state.PrefDrillType == 'DTH')
                { AddElement = false }
                var WorkingDTHPipes = []
                if(DTHGood == true && this.state.PrefDrillType != 'Rotary' && CurrentRig['DTH/Rotary'] != 'Rotary')
                {
                    //I need to check that for at least ONE bit is within the range of 20.
                    var OneWithinRange = false;
                    var Parsy = 0;
                    while (Parsy < WorkingDTHComps.length)
                    {
                        var AddCurrentPipe = false;
                        var InnerParsy = 0;
                        while (InnerParsy < WorkingDTHComps[Parsy].length)
                        {
                            if(WorkingDTHComps[Parsy][InnerParsy].length > 1)
                            {
                                var FinalParsy = 0;
                                while (FinalParsy < WorkingDTHComps[Parsy][InnerParsy].length)
                                {
                                    if(Math.abs(WorkingDTHComps[Parsy][InnerParsy][FinalParsy] - this.state.HoleSize_Millimeters) <= 20)
                                    { 
                                        OneWithinRange = true; 
                                        AddCurrentPipe = true;
                                    }
                                    FinalParsy++
                                }
                            }
                            InnerParsy++
                        }
                        if(AddCurrentPipe = true)
                        { WorkingDTHPipes.push(WorkingDTHComps[Parsy][0]) }
                        Parsy++
                    }
                    if(OneWithinRange == false)
                    { DTHGood = false; }
                }
                if(AddElement = true && this.state.PrefDrillType != 'DTH' && CurrentRig['DTH/Rotary'] != 'DTH')
                {
                    //We need to check that for at least one pipe size there is one comp with a corresponding bit in said pipe size.
                    var Pipes = []
                    var NewCorrectCombinations = []
                    var Counter = 0;
                    while (Counter < CorrectCombinations.length)
                    {
                        var Check = true;
                        var InnerCounter = 0;
                        while (InnerCounter < Pipes.length)
                        {
                            if(Pipes[InnerCounter] == CorrectCombinations[Counter][0])
                            { Check = false }
                            InnerCounter++
                        }
                        if(Check)
                        { Pipes.push(CorrectCombinations[Counter][0]) }
                        Counter++
                    }
                    //Okay, now pipes contains all of the names for the current drill.
                    Counter = 0;
                    while (Counter < Pipes.length)
                    {
                        var AddPipe = false;
                        var InnerCounter = 0;
                        while (InnerCounter < CorrectCombinations.length)
                        {
                            if(CorrectCombinations[InnerCounter][0] == Pipes[Counter])
                            {
                                var CompChecker = 0;
                                while (CompChecker < WorkingRotaryComps.length)
                                {
                                    if(Pipes[Counter] == WorkingRotaryComps[CompChecker][0])
                                    { 
                                        var CCompPipeParser = 1;
                                        while(CCompPipeParser < WorkingRotaryComps[CompChecker].length)
                                        {
                                            if(CorrectCombinations[InnerCounter][1] == WorkingRotaryComps[CompChecker][CCompPipeParser][1])
                                            { AddPipe = true }
                                            CCompPipeParser++
                                        }
                                    }
                                    CompChecker++
                                }
                            }
                            InnerCounter++
                        }
                        if(AddPipe)
                        {
                            InnerCounter = 0;
                            while (InnerCounter < CorrectCombinations.length)
                            {
                                if(CorrectCombinations[InnerCounter][0] == Pipes[Counter])
                                {
                                    var NewCombo = []
                                    NewCombo.push(CorrectCombinations[InnerCounter][0])
                                    NewCombo.push(CorrectCombinations[InnerCounter][1])
                                    NewCorrectCombinations.push(NewCombo)
                                }
                                InnerCounter++
                            }
                        }
                        Counter++
                    }
                    //Now NewCorrectCombinations should be all of the combinations that have the correct pipe data.
                    CorrectCombinations = NewCorrectCombinations;
                    if(CorrectCombinations.length == 0)
                    { AddElement = false }
                }
                if(AddElement || DTHGood)
                {
                    FilteredData.push(this.state.contacts[Parser]);
                    FilteredData[FilteredData.length - 1]["CorrectCombination"] = CorrectCombinations;
                    FilteredData[FilteredData.length - 1]["Rotary Works"] = AddElement;
                    FilteredData[FilteredData.length - 1]["DTH Works"] = DTHGood;
                    FilteredData[FilteredData.length - 1]["DTH Working Comps"] = WorkingDTHComps;
                    FilteredData[FilteredData.length - 1]["Rotary Working Comps"] = WorkingRotaryComps;
                }
            }
            Parser = Parser + 1;
          
        }
      if(FilteredData.length == 0)
      {
          var newList = [];
          newList.push(this.state.contacts[0]);
          this.setState({
              DrillResult: 1,
              ParsedDrills: newList,
              ChosenDrill: 0,
              HaveSearched: 1,
          })
      }
      else if(FilteredData[0]['drill_id'] == 1)
      {
          this.setState({
              DrillResult: 1,
              ParsedDrills: FilteredData,
              ChosenDrill: 1,
              HaveSearched: 1,
          })
      }
      else
      {
          this.setState({
              DrillResult: 1,
              ParsedDrills: FilteredData,
              ChosenDrill: 0,
              HaveSearched: 1,
          })
      }
    }

  
  Change_Chosen_Drill = (e) =>
  {
      this.setState({
          ChosenDrill: e.target.value,
          ChosenPipeSize: 0,
          RotChoice: 0,
          RotBitChoice: 0,
          ChosenHammerType: 0,
          HammerBitChoice: 0,
          DTHChoice: 0,
      })
  }
  
  Toggle_Show_Searcher = (e) =>
  {
      if(this.state.ShowSearcher == 0)
      {
        this.setState({
            ShowSearcher: 1,
        })    
      }
      else
      {
          this.setState({
              ShowSearcher: 0,
          })
      }
  }
  
  Change_Diameter = (e) =>
  {
      this.setState({
          HoleDiameter: e.target.value,
      })
  }

  Change_Hole_Depth = (e) =>
  {
      this.setState({
          HoleDepth: e.target.value,
      })
  }

  Change_Add_Hole_Depth = (e) =>
  {
      this.setState({
        SubDrilling: e.target.value,
      })
  }

  Change_UCSu = (e) =>
  {
      this.setState({
          UCSu: e.target.value,
      })
  }

  Change_CurrPenRate = (e) =>
  {
      this.setState({
          CurrPenRate: e.target.value,
          MeterDrilled: e.target.value,
          TargetProdH: 1,
      })
  }

  Change_Elevation = (e) =>
  {
      this.setState({
          Elevation: e.target.value,
      })
  }

  Change_Hole_Size = (e) =>
  {
      var HoleSizeIn = e.target.value / 25.4;
      this.setState({
          HoleSize: HoleSizeIn,
          HoleSize_Millimeters: e.target.value,
          HoleDiameter: e.target.value
      })
  }

  Change_Meter_Drilled = (e) =>
  {
      var CurrentPenRate = e.target.value / this.state.TargetProdH;
      this.setState({
          MeterDrilled: e.target.value,
          CurrPenRate: CurrentPenRate,
      })
  }

  Change_Target_Prod_H = (e) =>
  {
      var CurrentPenRate = this.state.MeterDrilled / this.state.TargetProdH;
      this.setState({
          TargetProdH: e.target.value,
          CurrPenRate: CurrentPenRate,
      })
  }

  Change_Pulldown = (e) =>
  {
      this.setState({
          Pulldown: e.target.value,
      })
  }

  Change_RPMu = (e) =>
  {
      this.setState({
          RPMu: e.target.value,
      })
  }

  Change_Air_Factor = (e) =>
  {
      this.setState({
          AirFactor: e.target.value,
      })
  }
  
  Change_Chosen_Pipe = (e) =>
  {
      this.setState({
          ChosenPipeSize: e.target.value,
          ShowRotary: true
      })
  }
  
  Change_Rot_Choice = (e) =>
  {
      this.setState({
          RotChoice: e.target.value
      })
  }
  
  Change_Chosen_Rot_Bit = (e) =>
  {
      this.setState({
          RotBitChoice: e.target.value
      })
  }
  
  Change_Hammer_Type = (e) =>
  {
      this.setState({
          ChosenHammerType: e.target.value
      })
  }
  
  Change_Chosen_Hammer_Bit = (e) =>
  {
      this.setState({
          HammerBitChoice: e.target.value
      })
  }
  
  Change_Chosen_DTH_Comp = (e) =>
  {
      this.setState({
          DTHChoice: e.target.value
      })
  }
  
  Change_PrefDrillType = (e) =>
  {
      this.setState({
          PrefDrillType: e.target.value
      })
  }
  
  Change_Input_Target = (e) =>
  {
      this.setState({
          Input_Target: e.target.value
      })
  }
  
  Set_Rotary_False = () =>
  {
      this.setState({
          ShowRotary: false,
      })
  }
  
  Get_Rot_Instant_Pen = () =>
  {
      var TooDeep = this.state.HoleDepth / 0.3 - this.state.ParsedDrills[this.state.ChosenDrill]['Single Pass'] - (this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Length'] * this.state.ParsedDrills[this.state.ChosenDrill]['Loader Cap']);
      var AddedPipe;
      if (TooDeep > 0)
      { AddElement = false; }
      else
      {
        AddedPipe = ((this.state.HoleDepth / 0.3) - this.state.ParsedDrills[this.state.ChosenDrill]['Single Pass']) / this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Length'];
        if (AddedPipe < 0)
        {
            AddedPipe *= -1;
            AddedPipe = Math.ceil(AddedPipe);
            AddedPipe *= -1;
        }
        else
            AddedPipe = Math.ceil(AddedPipe);
      }
      var Temp = 0;
      if (TooDeep > 0)
      {
          Temp = (parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] * this.state.ParsedDrills[this.state.ChosenDrill]['Loader Cap'] + (this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown'] / this.state.ParsedDrills[this.state.ChosenDrill]['Max Feed Pressure']) * this.state.Pulldown);
      }
      else
      {
          if (AddedPipe < 1)
          {
              Temp = parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] + (this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown'] / this.state.ParsedDrills[this.state.ChosenDrill]['Max Feed Pressure']) * this.state.Pulldown;
          }
          else
          {
              Temp = (parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] * (AddedPipe + 1) + (this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown'] / this.state.ParsedDrills[this.state.ChosenDrill]['Max Feed Pressure']) * this.state.Pulldown);
          }
      }
      var PenetrationRateRotary = (2.18 * Temp * this.state.RPMu) / (0.2 * (this.state.UCSu / 0.00689457) * Math.pow((this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Bit (in)'][this.state.RotBitChoice] / 25.4), 0.9) * (this.state.UCSu / 68.9457)) / (3.28083);
      return (PenetrationRateRotary / 60).toFixed(2);
  }
  
  Get_Bit_Avail_Weight = () =>
  {
      var TooDeep = this.state.HoleDepth / 0.3 - this.state.ParsedDrills[this.state.ChosenDrill]['Single Pass'] - (this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Length'] * this.state.ParsedDrills[this.state.ChosenDrill]['Loader Cap']);
      var AddedPipe;
      if (TooDeep > 0)
      { AddElement = false; }
      else
      {
        AddedPipe = ((this.state.HoleDepth / 0.3) - this.state.ParsedDrills[this.state.ChosenDrill]['Single Pass']) / this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Length'];
        if (AddedPipe < 0)
        {
            AddedPipe *= -1;
            AddedPipe = Math.ceil(AddedPipe);
            AddedPipe *= -1;
        }
        else
            AddedPipe = Math.ceil(AddedPipe);
      }
      var Temp = 0;
      if (TooDeep > 0)
      {
          Temp = (parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] * this.state.ParsedDrills[this.state.ChosenDrill]['Loader Cap'] + parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown']));
      }
      else
      {
          if (AddedPipe < 1)
          {
              Temp = parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] + parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown']);
          }
          else
          {
              Temp = (parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] * (AddedPipe + 1) + parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown']));
          }
      }
      return Math.round(Temp * 0.004448222);
  }
  
  Get_Rot_Bit_Weight = () =>
  {
      var TooDeep = this.state.HoleDepth / 0.3 - this.state.ParsedDrills[this.state.ChosenDrill]['Single Pass'] - (this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Length'] * this.state.ParsedDrills[this.state.ChosenDrill]['Loader Cap']);
      var AddedPipe;
      if (TooDeep > 0)
      { AddElement = false; }
      else
      {
        AddedPipe = ((this.state.HoleDepth / 0.3) - this.state.ParsedDrills[this.state.ChosenDrill]['Single Pass']) / this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Length'];
        if (AddedPipe < 0)
        {
            AddedPipe *= -1;
            AddedPipe = Math.ceil(AddedPipe);
            AddedPipe *= -1;
        }
        else
            AddedPipe = Math.ceil(AddedPipe);
      }
      var Temp = 0;
      if (TooDeep > 0)
      {
          Temp = (parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] * this.state.ParsedDrills[this.state.ChosenDrill]['Loader Cap'] + (this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown'] / this.state.ParsedDrills[this.state.ChosenDrill]['Max Feed Pressure']) * this.state.Pulldown);
      }
      else
      {
          if (AddedPipe < 1)
          {
              Temp = parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] + (this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown'] / this.state.ParsedDrills[this.state.ChosenDrill]['Max Feed Pressure']) * this.state.Pulldown;
          }
          else
          {
              Temp = (parseInt(this.state.ParsedDrills[this.state.ChosenDrill]['RH Weight']) + this.state.ParsedDrills[this.state.ChosenDrill]['Pipe Sizes'][this.state.ChosenPipeSize] * (AddedPipe + 1) + (this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Max Pulldown'] / this.state.ParsedDrills[this.state.ChosenDrill]['Max Feed Pressure']) * this.state.Pulldown);
          }
      }
      return Math.round(Temp * 0.004448222);
  }
  
  
  render() {
    return (
        <React.Fragment>
        { /*This is the page for when you've yet to login*/}
        { this.state.LoggedIn == 0 &&
        (
        <div>
        <h1>Login Page</h1>
        <label>Username</label>
        <input class="form-control" type="text" value={this.state.Username} onChange={e => this.Change_Username(e) }></input>
        <label>Password</label>
        <input class="form-control" type="password" value={this.state.Password} onChange={e => this.Change_Password(e) }></input>
        <button type="button" disabled={this.state.LoginButtonOff} class="btn btn-info" onClick={e => this.Login(e)}>Login</button>
        <button type="button" class="btn btn-info" onClick={e => this.Create_Account_Page(e)}>Create Account</button>   
        </div>
        )
        }
        {/* This is for when you have logged in, it's the drill searcher*/}
        {this.state.LoggedIn == 1 && this.state.PrintingPage == 0 &&
        (
        <React.Fragment>
        {this.state.HaveSearched != 0 && this.state.ParsedDrills.length == 1 && this.state.ParsedDrills[0]['drill_id'] == 1 &&
        (
        <div>No drills meet your serach parameters</div>
        )
        }
        {this.state.HaveSearched != 0 && this.state.ParsedDrills[0]['drill_id'] != 1 && 
        (
        <div>
            <select class="form-control" onChange={(e) => this.Change_Chosen_Drill(e)} value={this.state.ChosenDrill} name={this.state.ChosenDrill}>
            { 
                //We can assume that Name exists in the table since I don't let it get removed.
                (function (options, i, Drills) {
                    while (i < Drills.length)
                    {
                        if((i == 0)&&(!(Drills[i]['drill_id'] == 1)))
                        {options.push(<option value={i} id={i} selected="selected">{Drills[i]['Name']}</option>)}
                        else if(!(Drills[i]['drill_id'] == 1))
                        {options.push(<option value={i} id={i}>{Drills[i]['Name']}</option>)}
                        i = i + 1;
                    }
                    return options;
                })([], 0, this.state.ParsedDrills)
            }
            </select>
            <table border='1' width='100%'>
                <tr>
                    <td>Data Name</td>
                    <td>Value</td>
                </tr>
                {
                    (function (rows, Labels, Drill, Change_Chosen_Pipe, PipeChoice, HaveSearched) {
                        var Parser = 1;
                        if(Drill == undefined)
                        {
                            rows.push(
                                <tr>
                                    <td>{"Pipe Sizes"}</td>
                                    <td>{""}</td>
                                </tr>
                            )
                        }
                        else
                        {
                            var PipeOptions = []
                            if (!(HaveSearched == 0))
                            {
                                var Counter = 0
                                while (Counter < Drill['Rotary Working Comps'].length)
                                {
                                    if(Drill['Rotary Working Comps'][Counter].length > 1)
                                    {PipeOptions.push(Drill['Rotary Working Comps'][Counter][0])}
                                    Counter += 1
                                }
                                Counter = 0;
                                while (Counter < Drill['DTH Working Comps'].length)
                                {
                                    if(Drill['DTH Working Comps'][Counter].length > 1)
                                    {
                                        var InnerCounter = 0;
                                        var AddThePipe = true;
                                        while (InnerCounter < PipeOptions.length)
                                        {
                                            if(Drill['DTH Working Comps'][Counter][0] == PipeOptions[InnerCounter])
                                            { AddThePipe = false; }
                                            InnerCounter += 1
                                        }
                                        if(AddThePipe)
                                        { PipeOptions.push(Drill['DTH Working Comps'][Counter][0]) }
                                        Counter += 1
                                    }
                                }
                            }
                            else
                            {
                                PipeOptions = Drill['Pipe Sizes']
                            }
                            rows.push(
                                <tr>
                                    <td>{"Pipe Sizes"}</td>
                                    <td>
                                        <select class="form-control" onChange={(e) => Change_Chosen_Pipe(e)} value={PipeChoice} name={PipeChoice}>
                                        {
                                            (function (options, i, ChosenDrill, PipeList) 
                                            {
                                                if(ChosenDrill['drill_id'] == 1)
                                                {
                                                    <td>{""}</td>
                                                }
                                                else
                                                {
                                                    while (i < PipeList.length)
                                                    {
                                                        if((i == 0)&&(!(ChosenDrill['drill_id'] == 1)))
                                                        {options.push(<option value={i} id={i} selected="selected">{PipeList[i]}</option>)}
                                                        else if(!(ChosenDrill['drill_id'] == 1))
                                                        {options.push(<option value={i} id={i}>{PipeList[i]}</option>)}
                                                        i = i + 1;
                                                    }
                                                }
                                                return options;
                                            })([], 0, Drill, PipeOptions)
                                        }
                                        </select>
                                    </td>
                                </tr>
                            )
                        }
                        return rows;
                    })([], this.state.LabelNames, this.state.ParsedDrills[this.state.ChosenDrill], this.Change_Chosen_Pipe, this.state.ChosenPipeSize, this.state.HaveSearched)
                }
                {this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Works'] && 
                (
                <td colspan = "2" align = "center"><b>Rotary</b></td>
                )
                }
                    {this.state.ParsedDrills[this.state.ChosenDrill]['Rotary Works'] &&
                    (
                    (function (rows, Labels, Drill, ChosenPipeIndex, Change_Chosen_Rot_Comp, RotChoice, HaveSearched, Change_Chosen_Rot_Bit, RotBitChoice, Set_Rotary_False) {
                        if(HaveSearched == 0)
                        {
                            rows.push(
                                <tr>
                                    <td>{"Rotary Comp"}</td>
                                    <td>{""}</td>
                                </tr>
                            )
                            rows.push(
                                <tr>
                                    <td>{"Rotary Bit (mm)"}</td>
                                    <td>{""}</td>
                                </tr>
                            )
                        }
                        else
                        {
                            var PipeIndex = 0;
                            //First we parse through all the Rotary Working Comps for this drill and find which pipe we've chosen.
                            while (Drill['Rotary Working Comps'][PipeIndex][0] != Drill['Pipe Sizes'][ChosenPipeIndex])
                            {
                                PipeIndex += 1
                            }
                            //Now we know that our currently chosen pipe has its corresponding rotary comps at Drill['Rotary Working Comps'][PipeIndex].
                            //Thus we'll create a list to contain all of them.
                            var RotComps = []
                            var PipeParser = 1
                            //Set to one to skip the pipe itself.
                            while (PipeParser < Drill['Rotary Working Comps'][PipeIndex].length)
                            {
                                var NotAdded = true;
                                var Check = 0;
                                while (Check < RotComps.length)
                                {
                                    if(RotComps[Check] == Drill['Rotary Working Comps'][PipeIndex][PipeParser][0])
                                    NotAdded = false;
                                    Check++
                                }
                                if(NotAdded)
                                {
                                    //Now that we know it's not added, we need to check if we should add it (so there exists at least one bit size in our correct combinations for our chosen pipe size that also works with our rotary comp)
                                    var AddThisComp = false;
                                    var P = 0;
                                    while (P < Drill['CorrectCombination'].length)
                                    {
                                        if(Drill['CorrectCombination'][P][0] == Drill['Rotary Working Comps'][PipeIndex][0])
                                        {
                                            var CheckCompPipes = 1;
                                            while(CheckCompPipes < Drill['Rotary Working Comps'][PipeIndex].length)
                                            {
                                                if(Drill['Rotary Working Comps'][PipeIndex][CheckCompPipes][1] == Drill['CorrectCombination'][P][1])
                                                { AddThisComp = true;}
                                                CheckCompPipes++
                                            }
                                        }
                                        P++
                                    }
                                    if(AddThisComp)
                                    { RotComps.push(Drill['Rotary Working Comps'][PipeIndex][PipeParser][0]) }
                                }
                                PipeParser += 1
                            }
                            if(RotComps.length != 0)
                            {
                            rows.push(
                                <tr>
                                    <td>{"Rotary Comp"}</td>
                                    <td>
                                        <select class="form-control" onChange={(e) => Change_Chosen_Rot_Comp(e)} value={RotChoice} name={RotChoice}>
                                        {    
                                            (function (options, i, ChosenDrill, RotCompOptions) 
                                            {
                                                if(ChosenDrill['drill_id'] == 1)
                                                {
                                                    <td>{""}</td>
                                                }
                                                else
                                                {
                                                    while (i < RotCompOptions.length)
                                                    {
                                                        if((i == 0)&&(!(ChosenDrill['drill_id'] == 1)))
                                                        {options.push(<option value={i} id={i} selected="selected">{RotCompOptions[i]}</option>)}
                                                        else if(!(ChosenDrill['drill_id'] == 1))
                                                        {options.push(<option value={i} id={i}>{RotCompOptions[i]}</option>)}
                                                        i = i + 1;
                                                    }
                                                }
                                                return options;
                                            })([], 0, Drill, RotComps)
                                        }
                                        </select>
                                    </td>
                                </tr>
                            )
                            PipeParser = 0;
                            var RotBits = []
                            while (PipeParser < Drill['CorrectCombination'].length)
                            {
                                if(Drill['CorrectCombination'][PipeParser][0] == Drill['Pipe Sizes'][ChosenPipeIndex])
                                {
                                    //Now we just need to check that it's added for teh chosen comp.
                                    var AddBit = false;
                                    var CompCheck = 0;
                                    while(CompCheck < Drill['Rotary Working Comps'][PipeIndex].length)
                                    {
                                        if(Drill['Rotary Working Comps'][PipeIndex][CompCheck][0] == RotComps[RotChoice])
                                        {
                                            if(Drill['Rotary Working Comps'][PipeIndex][CompCheck][1] == Drill['CorrectCombination'][PipeParser][1])
                                            AddBit = true;
                                        }
                                        CompCheck++;
                                    }
                                    if(AddBit)
                                    { RotBits.push(Drill['CorrectCombination'][PipeParser][1]) }
                                }
                                PipeParser += 1
                            }
                            rows.push(
                                <tr>
                                    <td>{"Rotary Bit (mm)"}</td>
                                    <td>
                                        <select class="form-control" onChange={(e) => Change_Chosen_Rot_Bit(e)} value={RotBitChoice} name={RotBitChoice}>
                                        {    
                                            (function (options, i, ChosenDrill, RotBitOptions) 
                                            {
                                                if(ChosenDrill['drill_id'] == 1)
                                                {
                                                    <td>{""}</td>
                                                }
                                                else
                                                {
                                                    while (i < RotBitOptions.length)
                                                    {
                                                        if((i == 0)&&(!(ChosenDrill['drill_id'] == 1)))
                                                        {options.push(<option value={i} id={i} selected="selected">{RotBitOptions[i]}</option>)}
                                                        else if(!(ChosenDrill['drill_id'] == 1))
                                                        {options.push(<option value={i} id={i}>{RotBitOptions[i]}</option>)}
                                                        i = i + 1;
                                                    }
                                                }
                                                return options;
                                            })([], 0, Drill, RotBits)
                                        }
                                        </select>
                                    </td>
                                </tr>
                            )
                        }
                        }
                        return rows;
                    })([], this.state.LabelNames, this.state.ParsedDrills[this.state.ChosenDrill], this.state.ChosenPipeSize, this.Change_Rot_Choice, this.state.RotChoice, this.state.HaveSearched, this.Change_Chosen_Rot_Bit, this.state.RotBitChoice, this.Set_Rotary_False)
                    )
                    }
                {this.state.ParsedDrills[this.state.ChosenDrill]['DTH Works'] && 
                (
                <td colspan = "2" align = "center"><b>DTH</b></td>
                )
                }
                    {this.state.ParsedDrills[this.state.ChosenDrill]['DTH Works'] &&
                    (
                    (function (rows, Labels, Drill, ChosenPipeIndex, Change_Chosen_Rot_Comp, RotChoice, HaveSearched, Change_Chosen_Rot_Bit, RotBitChoice, CurrentWorkingHammers, Change_Hammer_Type, ChosenHammerType, Change_Chosen_Hammer_Bit, HammerBitChoice, Change_Chosen_DTH_Comp, DTHChoice) {
                        if(HaveSearched == 0)
                        {
                            rows.push(
                                <tr>
                                    <td>{"DTH Comp"}</td>
                                    <td>{""}</td>
                                </tr>
                            )
                            rows.push(
                                <tr>
                                    <td>{"Hammer Type"}</td>
                                    <td>{""}</td>
                                </tr>
                            )
                            rows.push(
                                <tr>
                                    <td>{"Hammer Bit (mm)"}</td>
                                    <td>{""}</td>
                                </tr>
                            )
                        }
                        else
                        {
                            var Counter = 0;
                            var GoodHammers = []
                            //First we parse through all the Rotary Working hammers
                            while (Counter != CurrentWorkingHammers.length)
                            {
                                if(CurrentWorkingHammers[Counter].length > 1)
                                {
                                    GoodHammers.push(CurrentWorkingHammers[Counter][0])
                                }
                                Counter += 1
                            }
                            //Now we know what our good hammers are we create a list of them
                            var CurrentHammer = 0;
                            if (GoodHammers.length > 0)
                            {
                            while (CurrentWorkingHammers[CurrentHammer][0] != GoodHammers[ChosenHammerType])
                            {
                                CurrentHammer += 1
                            }
                            var HammerParser = 1;
                            var HammerBits = []
                            
                            var PipeIndex = 0;
                            //First we parse through all the Rotary Working Comps for this drill and find which pipe we've chosen.
                            while (Drill['DTH Working Comps'][PipeIndex][0] != Drill['Pipe Sizes'][ChosenPipeIndex])
                            {
                                PipeIndex += 1
                            }
                            //Now we know that our currently chosen pipe has its corresponding rotary comps at Drill['Rotary Working Comps'][PipeIndex].
                            //Thus we'll create a list to contain all of them.
                            var DTHComps = []
                            var PipeParser = 1
                            //Set to one to skip the pipe itself.
                            while (PipeParser < Drill['DTH Working Comps'][PipeIndex].length)
                            {
                                if(typeof(Drill['DTH Working Comps'][PipeIndex][PipeParser]) != typeof([]))
                                { DTHComps.push(Drill['DTH Working Comps'][PipeIndex][PipeParser]) }
                                PipeParser += 1
                            }  
                            var HamCount = 0;
                            var NewGoodHammers = []
                            var NewWorkingHammers
                            while (HamCount < CurrentWorkingHammers.length)
                            {
                                var NewHammerBits = []
                                var NewHamParser = 1;
                                var HammerSetup = []
                                while (NewHamParser < CurrentWorkingHammers[HamCount].length)
                                {
                                    var AddCurrentHammer = false;
                                    var WhereComp = 0;
                                    while (Drill['DTH Working Comps'][PipeIndex][WhereComp] != DTHComps[DTHChoice])
                                    { WhereComp++; }
                                    var Counter = 0;
                                    var WorkingDrillBits = Drill['DTH Working Comps'][PipeIndex][WhereComp + 1];
                                    while (Counter < WorkingDrillBits.length)
                                    {
                                        if(WorkingDrillBits[Counter] == CurrentWorkingHammers[HamCount][NewHamParser])
                                        { AddCurrentHammer = true; }
                                        Counter++;
                                    }
                                    if(AddCurrentHammer)
                                    { NewHammerBits.push(CurrentWorkingHammers[HamCount][NewHamParser]) }
                                    NewHamParser += 1
                                }
                                if(NewHammerBits.length != 0)
                                {
                                    HammerSetup.push(CurrentWorkingHammers[HamCount][0])
                                    HammerSetup.push(HamCount)
                                    NewGoodHammers.push(HammerSetup)
                                }
                                HamCount++;
                            }
                            GoodHammers = NewGoodHammers;   
                            var HaveChanged = false;
                            var C = 0;
                            while(C < GoodHammers.length)
                            {
                                if(CurrentWorkingHammers[CurrentHammer][0] == GoodHammers[C][0])
                                { HaveChanged = true; }
                                C++
                            }
                            if(HaveChanged == false && GoodHammers.length > 0)
                            {
                                var InCount = 0;
                                while(GoodHammers[0][0] != CurrentWorkingHammers[InCount][0])
                                { InCount++; }
                                CurrentHammer = InCount;
                            }
                            while (HammerParser < CurrentWorkingHammers[CurrentHammer].length)
                            {
                                var AddCurrentHammer = false;
                                var WhereComp = 0;
                                while (Drill['DTH Working Comps'][PipeIndex][WhereComp] != DTHComps[DTHChoice])
                                { WhereComp++; }
                                var Counter = 0;
                                var WorkingDrillBits = Drill['DTH Working Comps'][PipeIndex][WhereComp + 1];
                                while (Counter < WorkingDrillBits.length)
                                {
                                    if(WorkingDrillBits[Counter] == CurrentWorkingHammers[CurrentHammer][HammerParser])
                                    { AddCurrentHammer = true; }
                                    Counter++;
                                }
                                if(AddCurrentHammer)
                                { HammerBits.push(CurrentWorkingHammers[CurrentHammer][HammerParser]) }
                                HammerParser += 1
                            }
                            if(GoodHammers.length != 0)
                            {
                            rows.push(
                                <tr>
                                    <td>{"Hammer Type"}</td>
                                    <td>
                                        <select class="form-control" onChange={(e) => Change_Hammer_Type(e)} value={ChosenHammerType} name={ChosenHammerType}>
                                        {    
                                            (function (options, i, ChosenDrill, GoodHammerOptions) 
                                            {
                                                if(ChosenDrill['drill_id'] == 1)
                                                {
                                                    <td>{""}</td>
                                                }
                                                else
                                                {
                                                    while (i < GoodHammerOptions.length)
                                                    {
                                                        if((i == 0)&&(!(ChosenDrill['drill_id'] == 1)))
                                                        {options.push(<option value={i} id={i} selected="selected">{GoodHammerOptions[i][0]}</option>)}
                                                        else if(!(ChosenDrill['drill_id'] == 1))
                                                        {options.push(<option value={i} id={i}>{GoodHammerOptions[i][0]}</option>)}
                                                        i = i + 1;
                                                    }
                                                }
                                                return options;
                                            })([], 0, Drill, GoodHammers)
                                        }
                                        </select>
                                    </td>
                                </tr>
                            )
                            rows.push(
                                <tr>
                                    <td>{"Hammer Bit (mm)"}</td>
                                    <td>
                                        <select class="form-control" onChange={(e) => Change_Chosen_Hammer_Bit(e)} value={HammerBitChoice} name={HammerBitChoice}>
                                        {    
                                            (function (options, i, ChosenDrill, HammerBitOptions) 
                                            {
                                                if(ChosenDrill['drill_id'] == 1)
                                                {
                                                    <td>{""}</td>
                                                }
                                                else
                                                {
                                                    while (i < HammerBitOptions.length)
                                                    {
                                                        if((i == 0)&&(!(ChosenDrill['drill_id'] == 1)))
                                                        {options.push(<option value={i} id={i} selected="selected">{HammerBitOptions[i]}</option>)}
                                                        else if(!(ChosenDrill['drill_id'] == 1))
                                                        {options.push(<option value={i} id={i}>{HammerBitOptions[i]}</option>)}
                                                        i = i + 1;
                                                    }
                                                }
                                                return options;
                                            })([], 0, Drill, HammerBits)
                                        }
                                        </select>
                                    </td>
                                </tr>
                            )
                            rows.push(
                                <tr>
                                    <td>{"DTH Comp"}</td>
                                    <td>
                                        <select class="form-control" onChange={(e) => Change_Chosen_DTH_Comp(e)} value={DTHChoice} name={DTHChoice}>
                                        {    
                                            (function (options, i, ChosenDrill, DTHCompOptions) 
                                            {
                                                if(ChosenDrill['drill_id'] == 1)
                                                {
                                                    <td>{""}</td>
                                                }
                                                else
                                                {
                                                    while (i < DTHCompOptions.length)
                                                    {
                                                        if((i == 0)&&(!(ChosenDrill['drill_id'] == 1)))
                                                        {options.push(<option value={i} id={i} selected="selected">{DTHCompOptions[i]}</option>)}
                                                        else if(!(ChosenDrill['drill_id'] == 1))
                                                        {options.push(<option value={i} id={i}>{DTHCompOptions[i]}</option>)}
                                                        i = i + 1;
                                                    }
                                                }
                                                return options;
                                            })([], 0, Drill, DTHComps)
                                        }
                                        </select>
                                    </td>
                                </tr>
                            )
                            }
                        }
                        else
                        {
                            rows.push(
                                <tr>
                                    <td>{"Hammer Bit (mm)"}</td>
                                    <td>{""}</td>
                                </tr>
                            )
                        }
                        }
                        return rows;
                    })([], this.state.LabelNames, this.state.ParsedDrills[this.state.ChosenDrill], this.state.ChosenPipeSize, this.Change_Rot_Choice, this.state.RotChoice, this.state.HaveSearched, this.Change_Chosen_Rot_Bit, this.state.RotBitChoice, this.state.CurrentWorkingHammers, this.Change_Hammer_Type, this.state.ChosenHammerType, this.Change_Chosen_Hammer_Bit, this.state.HammerBitChoice, this.Change_Chosen_DTH_Comp, this.state.DTHChoice)
                )
                }
            </table>
            <button class="btn btn-info" onClick={(e) => this.Toggle_Show_Searcher(e)}>Toggle Searcher</button>
        </div>
        )        
        }
        {(this.state.ShowSearcher == 0) &&
        (
        <div>
        <h1>Search For Drills</h1>
        <table border='1' width='100%' >
        <tr>
            <td>Data Name</td>
            <td>Input</td>
        </tr>
        <tr>
            <td>Elevation</td>
            <td><input class="form-control" type="text" value={this.state.Elevation} onChange={e => this.Change_Elevation(e)}></input></td>
        </tr>
        <tr>
            <td>Bit (mm)</td>
            <td><input class="form-control" type="text" value={this.state.HoleSize_Millimeters} onChange={e => this.Change_Hole_Size(e)}></input></td>
        </tr>
        <tr>
            <td>Hole Depth</td>
            <td><input class="form-control" type="text" value={this.state.HoleDepth} onChange={e => this.Change_Hole_Depth(e)}></input></td>
        </tr>
        <tr>
            <td>Rock Density (UCS)</td>
            <td><input class="form-control" type="text" value={this.state.UCSu} onChange={e => this.Change_UCSu(e)}></input></td>
        </tr>
        <tr>
            <td colspan="2">
            <select class="form-control" onChange={(e) => this.Change_Input_Target(e)} value={this.state.Input_Target} name={this.state.Input_Target}>
                <option value={0} id={0} selected="selected">Meters Drilled + Target Production</option> 
                <option value={1} id={1}>Current Pen Rate</option> 
            </select>
            </td>
        </tr>
        {this.state.Input_Target == 1 &&
        (
        <tr>
            <td>Current Pen Rate</td>
            <td><input class="form-control" type="text" value={this.state.CurrPenRate} onChange={e => this.Change_CurrPenRate(e)}></input></td>
        </tr>
        )
        }
        {this.state.Input_Target == 0 &&
        (
        <tr>
            <td>Meters Drilled (month)</td>
            <td><input class="form-control" type="text" value={this.state.MeterDrilled} onChange={e => this.Change_Meter_Drilled(e)}></input></td>
        </tr>
        )
        }
        {this.state.Input_Target == 0 &&
        (
        <tr>
            <td>Target Production (hr/month)</td>
            <td><input class="form-control" type="text" value={this.state.TargetProdH} onChange={e => this.Change_Target_Prod_H(e)}></input></td>
        </tr>
        )
        }
        <tr>
            <td>DTH/Rotary</td>
            <td>
                <select class="form-control" onChange={(e) => this.Change_PrefDrillType(e)} value={this.state.PrefDrillType} name={this.state.PrefDrillType}>
                   <option value={'Both'} id={0} selected="selected">Either</option> 
                   <option value={'DTH'} id={1}>DTH</option> 
                   <option value={'Rotary'} id={2}>Rotary</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan = "2" align = "center"><b>Rotary</b></td>
        </tr>
        <tr>
            <td>RPM</td>
            <td><input class="form-control" type="text" value={this.state.RPMu} onChange={e => this.Change_RPMu(e)}></input></td>
        </tr>
        <tr>
            <td>Pulldown</td>
            <td><input class="form-control" type="text" value={this.state.Pulldown} onChange={e => this.Change_Pulldown(e)}></input></td>
        </tr>
        <tr>
            <td colspan = "2" align = "center"><b>DTH</b></td>
        </tr>
        <tr>
            <td>Air Factor</td>
            <td>
                <select class="form-control" onChange={(e) => this.Change_Air_Factor(e)} value={this.state.AirFactor} name={this.state.AirFactor}>
                   <option value={0.46} id={0} selected="selected">180</option> 
                   <option value={1} id={1}>350</option> 
                   <option value={1.465} id={2}>500</option>
                </select>
            </td>
        </tr>
        </table>
        <button class="btn btn-info" onClick={(e) => this.Drill_Search(e)}>Run Search</button>
        <a href="/sandvik-drill-parser/" class="btn btn-warning">Drill List</a>
        </div>
        )
        }
        </React.Fragment>
        )
        }
        {/* This is for when you're creating an account*/}
        {this.state.LoggedIn == 2 &&
        (
        <div>
            <h1>Create an account</h1>
            <label>Username</label>
            <input class="form-control" type="text" value={this.state.Username} onChange={e => this.Change_Username(e) }></input>
            <label>Password</label>
            <input class="form-control" type="text" value={this.state.Password} onChange={e => this.Change_Password(e) }></input>
            <button type="button" class = "btn btn-info" onClick={e => this.Create_Account(e)}>Create New Account</button>
            <button type="button" class= "btn btn-info" onClick={e => this.Logout(e)}>Return To Login</button>
        </div>
        )                    
        }
        {/* This is a warning if a bad character (one that breaks the mysql query) was added to the username or password*/ }
        {this.state.ErrorAddedBadChar &&
        (
                <div>
                    Error! Do not add {this.state.BadChar} to username or passwords.
                </div>
        )        
        }
        </React.Fragment>
    );
  }
}

ReactDOM.render(<App />, document.getElementById('root'));
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    
<script>
if('serviceWorker' in navigator) {
  navigator.serviceWorker
           .register('swo.js')
           .then(function() { console.log("Service Worker Registered"); });
}
</script>
    
</body>   
</html>