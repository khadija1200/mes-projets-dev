import React from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import { useNavigate } from "react-router-dom";




// reactstrap components
import {
  Button,
  Card,
  CardHeader,
  CardBody,
  CardFooter,
  Form,
  Input,
  InputGroupAddon,
  InputGroupText,
  InputGroup,
  Container,
  Col,
  Alert
} from "reactstrap";



function SignupPage() {
  const [firstFocus, setFirstFocus] = React.useState(false);
  const [lastFocus, setLastFocus] = React.useState(false);
  React.useEffect(() => {
    document.body.classList.add("login-page");
    document.body.classList.add("sidebar-collapse");
    document.documentElement.classList.remove("nav-open");
    window.scrollTo(0, 0);
    document.body.scrollTop = 0;
    return function cleanup() {
      document.body.classList.remove("login-page");
      document.body.classList.remove("sidebar-collapse");
    };
  }, []);

  const [formData, setFormData] = React.useState({
  nom: "",
  prenom: "",
  dateNaissance: "",
  genre: "",
  telephone: "",
  email: "",
  password: "",
  role: ""
});
const [alertSuccess, setAlertSuccess] = React.useState(false);
const [alertError, setAlertError] = React.useState(false);
const [errorMessage, setErrorMessage] = React.useState("");


const handleChange = (e) => {
  setFormData({ ...formData, [e.target.name]: e.target.value });
};
const navigate = useNavigate();


const handleSignUp = async (e) => {
  e.preventDefault();
  try {
    const res = await axios.post("http://localhost:3001/api/signup", formData);
   setAlertSuccess(true);
   setTimeout(() => {
      navigate("/login");
     }, 1500);
  } catch (err) {
    setErrorMessage(err.response?.data?.message || "Erreur lors de l'inscription");
    setAlertError(true);

  }
};


  return (
    <>
      {/* <ExamplesNavbar /> */}
      <div className="page-header clear-filter" filter-color="blue">
        <div
          className="page-header-image"
          style={{
            backgroundImage: "url(" + require("assets/img/login.jpg") + ")"
          }}
        ></div>
        <div className="content">
          <Container>
            <Col className="ml-auto mr-auto" md="4">
              <Card className="card-login card-plain">
                <Form action="" className="form" method="">
                  <CardHeader className="text-center">
                    {/* <div className="logo-container"> */}
                      {/* <img
                        alt="..."
                        src={require("assets/img/now-logo.png")}
                      ></img> */}
                      <div class="text-center card-header">
                        <h3 class="title-up card-title">Créer un compte</h3>
                      </div>
                    {/* </div> */}
                  </CardHeader>
                  <div className="section section-notifications">
                  {/* ✅ Notification succès */}
<Alert color="success" isOpen={alertSuccess}>
  <Container>
    <div className="alert-icon">
      <i className="now-ui-icons ui-2_like"></i>
    </div>
    <strong>Succès !</strong> Opération réussie.
    <button type="button" className="close" onClick={() => setAlertSuccess(false)}>
      <span aria-hidden="true">
        <i className="now-ui-icons ui-1_simple-remove"></i>
      </span>
    </button>
  </Container>
</Alert>

{/* ❌ Notification erreur */}
<Alert color="danger" isOpen={alertError}>
  <Container>
    <div className="alert-icon">
      <i className="now-ui-icons objects_support-17"></i>
    </div>
    <strong>Erreur !</strong> {errorMessage}
    <button type="button" className="close" onClick={() => setAlertError(false)}>
      <span aria-hidden="true">
        <i className="now-ui-icons ui-1_simple-remove"></i>
      </span>
    </button>
  </Container>
</Alert>
</div>

                 <CardBody>
  <InputGroup className="no-border input-lg">
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons users_single-02"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input placeholder="Nom" type="text"  name="nom"  value={formData.nom}
  onChange={handleChange} />
  </InputGroup>

  <InputGroup className="no-border input-lg">
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons users_single-02"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input placeholder="Prénom" type="text" name="prenom"  value={formData.prenom}
  onChange={handleChange}/>
  </InputGroup>

  <InputGroup className="no-border input-lg">
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons ui-1_calendar-60"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input placeholder="Date de naissance" name="dateNaissance" type="date" value={formData.dateNaissance}
  onChange={handleChange} />
  </InputGroup>

  <InputGroup className="no-border input-lg">
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons users_single-02"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input type="select" name="genre" value={formData.genre} onChange={handleChange}>
      <option>Genre</option>
      <option>Homme</option>
      <option>Femme</option>
      <option>Autre</option>
    </Input>
  </InputGroup>

  <InputGroup className="no-border input-lg">
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons tech_mobile"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input placeholder="Numéro de téléphone" type="tel" name="telephone"
  value={formData.telephone}
  onChange={handleChange}/>
  </InputGroup>

   <InputGroup className="no-border input-lg">
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons users_single-02"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input type="select" name="role" value={formData.role} onChange={handleChange} >
      <option>Rôle</option>
      <option>client</option>
      <option>professionnel</option>
    </Input>
  </InputGroup>


  {/* Email */}
  <InputGroup
    className={
      "no-border input-lg" + (firstFocus ? " input-group-focus" : "")
    }
  >
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons ui-1_email-85"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input
      placeholder="Email..."
      type="text"
        name="email"
      value={formData.email}
        onChange={handleChange}
      onFocus={() => setFirstFocus(true)}
      onBlur={() => setFirstFocus(false)}
    ></Input>
  </InputGroup>

  {/* Mot de passe */}
  <InputGroup
    className={
      "no-border input-lg" + (lastFocus ? " input-group-focus" : "")
    }
  >
    <InputGroupAddon addonType="prepend">
      <InputGroupText>
        <i className="now-ui-icons text_caps-small"></i>
      </InputGroupText>
    </InputGroupAddon>
    <Input
      placeholder="Mot de passe...."
      type="password"
      name="password"
     value={formData.password}
     onChange={handleChange}
      onFocus={() => setLastFocus(true)}
      onBlur={() => setLastFocus(false)}
    ></Input>
  </InputGroup>
</CardBody>

                  <CardFooter className="text-center">
                    <Button
                      block
                      className="btn-round"
                      color="info"
                      href="#pablo"
                      onClick={handleSignUp}
                      size="lg"
                      
                    >
                      S'inscrire
                    </Button>
                    
                    <div className="text-center">
                      <h6>
                        <Link className="link" to="/login"> Vous avez déjà un compte ? </Link>
                         
                       
                      </h6>
                    </div>
                  </CardFooter>
                </Form>
              </Card>
            </Col>
          </Container>
        </div>
        {/* <TransparentFooter /> */}
      </div>
    </>
  );
}

export default SignupPage;
