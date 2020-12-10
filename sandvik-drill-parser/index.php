<!DOCTYPE html>
<html lang="en">
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

class ContactForm extends React.Component {
    state = {
        drill_id: '',
        name: '',
        pipe_size_count: '',
        Column_Name: '',
        Input_Type_For_Column: '',
        Inputs: [],
    }

    handleFormSubmit( event ) {
        event.preventDefault();


        let formData = new FormData();
        // This should add all of the form elements including those we added via the UI etc.
        var Parser = 2;
        while (Parser < this.props.LabelNames.length + 2)
        {
            //First we set $_POST[0] to 0 to indicicate that we're adding to the table.
            formData.append(0, 0);
            //Then lets add how many labels there are.
            formData.append(1, this.props.LabelNames.length);
            //Then we add the labels themselves to the parser.
            formData.append(Parser, this.props.LabelNames[Parser - 2]);
            //Then we add the data that the labels map to.
            console.log(this.props.LabelNames[Parser - 2] + " " + this.state.Inputs[Parser - 2]);
            formData.append(this.props.LabelNames[Parser - 2].split(" ").join(""), this.state.Inputs[Parser - 2]);
            Parser = Parser + 1;
        }

        axios({
            method: 'post',
            url: 'api/contacts.php',
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
    
    AddColumn( event) {
        event.preventDefault();
        let formData = new FormData();
        //Append 1 to $_POST[0] to show that we're adding a column.
        formData.append(0, 1);
        formData.append(1, this.state.Column_Name);
        axios({
            method: 'post',
            url: 'api/contacts.php',
            data: formData,
            config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then((response) => {
            //handle success
            console.log(response)
            //Now that we've added the column we need to create a new table for said column for auto-incrementing
            //when searching for it in the search feature.
            formData = new FormData();
            //Append 4 to $_POST[0] to show that we're creating a new table.
            formData.append(0, 4);
            formData.append(1, this.state.Column_Name);
            axios({
                method: 'post',
                url: 'api/contacts.php',
                data: formData,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .then((response) => {
                //handle success
                console.log(response)
                //Now we need to add a column for its Input_Type
                formData = new FormData();
                //Append 6 to $_POST[0] to show that we're adding the Input_Type column to the table.
                formData.append(0, 6);
                formData.append(1, this.state.Column_Name);
                axios({
                    method: 'post',
                    url: 'api/contacts.php',
                    data: formData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
                .then((response) => {
                    //handle success
                    console.log(response)
                    //Now that we've added the new table we need to set its first value to 0 so that it defaults
                    //to text when we're inputting it into the search system.
                    formData = new FormData();
                    //Append 7 to $_POST[0] to show that we're adding 0 to the new table.
                    formData.append(0, 7);
                    formData.append(1, this.state.Column_Name);
                    axios({
                        method: 'post',
                        url: 'api/contacts.php',
                        data: formData,
                        config: { headers: {'Content-Type': 'multipart/form-data' }}
                    })
                    .then((response) => {
                        //handle success
                        console.log(response)
                    })
                    .catch(function (response) {
                        //handle error
                        console.log(response)
                    });
                })
                .catch(function (response) {
                    //handle error
                    console.log(response)
                });
            })
            .catch(function (response) {
                //handle error
                console.log(response)
            });
        })
        .catch(function (response) {
            //handle error
            console.log(response)
        });
    }
        
    Change_Input = (e) =>
    {
        var Index = e.target.id;
        var InputArray = this.state.Inputs;
        while (InputArray.length < Index - 1)
        {
            InputArray.push("");
        }
        InputArray[Index] = e.target.value;
        this.setState({
            Inputs: InputArray,
        })
    };

    render(){
        return (
        <div>
        <form>
            {(function (rows, i, LabelNames, Inputs, Change_Input) {
                while (i < LabelNames.length)
                {
                    rows.push(
                    <div>
                    <label>{LabelNames[i]}</label>
                    <input class="form-control" type="text" value={Inputs[i]} id={i}
                        onChange={e => Change_Input(e) } key={i}></input>
                    </div>
                    )
                    i = i + 1;
                }
                return rows;
            })([], 1, this.props.LabelNames, this.state.Inputs, this.Change_Input)}
            <button  type="button" class="btn btn-primary" onClick={e => this.handleFormSubmit(e)}>Add Drill</button>
        </form>
        {/*<form>
            <label> Column Name</label>
            <input class ="form-control" type="text" name="Column_Name" value={this.state.Column_Name}
                onChange={e => this.setState({Column_Name: e.target.value })}/>
            <button  type="button" class="btn btn-primary" onClick={e => this.AddColumn(e)}>Add Column</button>
        </form>*/}
        </div>);
    }
}

class App extends React.Component {
  state = {
    contacts: [],
    LabelNames: [],
    CurrentID: 0,
    ToggleEditing: 0,
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
        
 componentDidMount() {
    const url = 'api/contacts.php'
    axios.get(url).then(response => response.data)
    .then((data) => {
      this.setState({ contacts: data, })
      let Labels = [];
      {
      for (var J in this.state.contacts[0])
      { 
        Labels.push(J);
      }
      }
      this.setState({ LabelNames: Labels, });
     })
  }

 Delete_Column = (e) =>
 {
    let formData = new FormData();
    //Append 2 to $_POST[0] to show that we're deleting a column.
    formData.append(0, 2);
    formData.append(1, this.state.LabelNames[e.target.id]);
    this.setState({ CurrentID: e.target.id, });
    axios({
        method: 'post',
        url: 'api/contacts.php',
        data: formData,
        config: { headers: {'Content-Type': 'multipart/form-data' }}
    })
    .then((response, e) => {
        //handle success
        console.log(response)
        //Now we run another request to delete the table that that column was connected to.
        formData = new FormData();
        //Append 5 to $_POST[0] to show that we're deleting a table.
        formData.append(0, 5);
        formData.append(1, this.state.LabelNames[this.state.CurrentID]);
        axios({
            method: 'post',
            url: 'api/contacts.php',
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
    })
    .catch(function (response) {
        //handle error
        console.log(response)
    });
 };

 Delete_Element = (e) =>
 {
    let formData = new FormData();
    //Append 3 to $_POST[0] to show that we're deleting an element.
    formData.append(0, 3);
    formData.append(1, e.target.id);
    axios({
        method: 'post',
        url: 'api/contacts.php',
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
  
  render() {
    return (
        <React.Fragment>
        <h1>Drill List</h1>
        <table border='1' width='100%' >
        <tr>
        {(function (rows, i, Labels, Delete_Column, ToggleEditing) {
            while (i < Labels.length)
            {
                if(!(i == 0))
                {
                   if((Labels[i] == 'Name')||(ToggleEditing == '0'))
                   {rows.push(<th key={i} id={i}>{Labels[i]}</th>);}
                   else
                   {
                    rows.push(<th key={i} id={i}>{Labels[i]}
                                {/*<button type="button" class="btn btn-secondary" id={i} key={i} style={{float: 'right'}} onClick={e => Delete_Column(e)}>Delete Column</button>*/}
                              </th>);
                   }
                }
                i = i + 1;
            }
            return rows;
        })([], 0, this.state.LabelNames, this.Delete_Column, this.state.ToggleEditing)}   
        </tr>

        {this.state.contacts.map((Drill) => (
        <tr>
        {(function (rows, i, Labels, Delete_Element, ToggleEditing) {
            if (!(Drill.drill_id == 1))
            {
            while (i < Labels.length)
            {
                if((i == Labels.length - 1)&&(ToggleEditing=='1'))
                {
                    rows.push(<td key={i}>{ Drill[String(Labels[i])]}
                                <button type="button" class="btn btn-secondary" id={Drill[String(Labels[0])]} key={i} style={{float: 'right'}} onClick={e => Delete_Element(e)}>Delete Element</button>
                              </td>)
                }
                else if(!(i == 0))
                {
                    rows.push(<td key={i}>{ Drill[String(Labels[i])]}</td>)    
                }
                i = i + 1;
            }
            }
            return rows;
        })([], 0, this.state.LabelNames, this.Delete_Element, this.state.ToggleEditing)}
        </tr>
        ))}
        </table>
        {this.state.ToggleEditing=='1' &&
        (
        <ContactForm 
        contacts={this.state.contacts}
        LabelNames={this.state.LabelNames}
        />
        )
        }
        <button type="button" class="btn btn-info" onClick={e => this.Toggle_Editing()}>Toggle Editing</button>
        <a class="btn btn-warning" href='/Find-Drill-System/index.php'>Find Drill</a>
        </React.Fragment>
    );
  }
}

ReactDOM.render(<App />, document.getElementById('root'));
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</body>   
</html>