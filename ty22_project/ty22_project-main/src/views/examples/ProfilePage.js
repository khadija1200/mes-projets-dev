import React, { useEffect, useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

// reactstrap components
import {
  Button,
  NavItem,
  NavLink,
  Nav,
  TabContent,
  TabPane,
  Container,
  Row,
  Col,
  UncontrolledTooltip
} from "reactstrap";

// core components
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import ProfilePageHeader from "components/Headers/ProfilePageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function ProfilePage() {
  const [pills, setPills] = React.useState("1");
  const [userData, setUserData] = useState(null);
 const navigate = useNavigate();
const [userId, setUserId] = useState(() => localStorage.getItem("userId"));
const [role, setRole] = useState(() => localStorage.getItem("role"));


  React.useEffect(() => {
    const userId = localStorage.getItem("userId");
    if (userId) {
      axios.get(`http://localhost:3001/api/user/${userId}`)
        .then((res) => setUserData(res.data))
        .catch((err) => console.error(err));
        
    }
    document.body.classList.add("profile-page");
    document.body.classList.add("sidebar-collapse");
    document.documentElement.classList.remove("nav-open");
    window.scrollTo(0, 0);
    document.body.scrollTop = 0;
    return function cleanup() {
      document.body.classList.remove("profile-page");
      document.body.classList.remove("sidebar-collapse");
    };
  }, []);

  const handleLogout = () => {
  setUserId(null);
  setRole(null);
  localStorage.removeItem("userId");
  localStorage.removeItem("role");
  localStorage.removeItem("token"); 
   navigate("/index")
};

  if (!userData) return <p>Chargement...</p>;

  const { user, prestataire,posts } = userData;
  console.log(user);
  return (
    <>
      <ExamplesNavbar userId={userId} role={role} onLogout={handleLogout}  />
      <div className="wrapper">
        <ProfilePageHeader  user={user} />
        <div className="section">
          <Container>
            <div className="button-container">
              <Button  onClick={() => navigate("/modifier-profil")} className="btn-round" color="info" size="lg">
                Modifier Mon profile
              </Button>
              <Button  onClick={() => navigate("/messages")} className="btn-round" color="info" size="lg">
                Voir mes discussions
              </Button>
              {user.role === "professionnel"  && (
               <Button  onClick={() => navigate("/ajouter-post")} className="btn-round" color="info" size="lg">
                Ajouter un post    
              </Button>
              )}
            </div>
           
            <h3 className="title">About me</h3>
            <h5 className="description">
            <p><strong>Email :</strong> {user.email}</p>
            <p><strong>Rôle :</strong> {user.role}</p>
              <p><strong>genre :</strong> {user.genre}</p>
                <p><strong>date de naissance :</strong> {user.dateNaissance}</p>
                <p><strong>telephone :</strong> {user.telephone}</p>
                {user.role === "professionnel" && prestataire && (
                   <>
                 <p><strong>Adresse :</strong> {prestataire.adresse}</p>
                <p><strong>ville :</strong> {prestataire.ville}</p>
                <p><strong>codePostal :</strong> {prestataire.codePostal}</p>
                <p><strong>pays :</strong> {prestataire.pays}</p>
                 <p><strong>specialite :</strong> {prestataire.specialite}</p>
                  <p><strong>description :</strong> {prestataire.description}</p>
                    <p><strong>deuxieme description :</strong> {prestataire.description2}</p>
                     <p><strong>tarifHoraire :</strong> {prestataire.tarifHoraire}</p>
                      <p><strong>disponibilite :</strong> {prestataire.disponibilite}</p>
                      <p><strong>siteWeb :</strong> {prestataire.siteWeb}</p>
                   </> 
                   )}
            </h5>
            {user.role === "professionnel" && posts && (
              <>
           <Row>
  <Col className="ml-auto mr-auto" md="6">
    <h4 className="title text-center">Mon Portfolio</h4>
    <div className="nav-align-center">
      <Nav className="nav-pills-info nav-pills-just-icons" pills role="tablist">
        {posts.length > 0 && (
          <NavItem>
            <NavLink
              className={pills === "1" ? "active" : ""}
              href="#"
              onClick={(e) => {
                e.preventDefault();
                setPills("1");
              }}
            >
              <i className="now-ui-icons design_image"></i>
            </NavLink>
          </NavItem>
        )}
        {posts.length > 4 && (
          <NavItem>
            <NavLink
              className={pills === "2" ? "active" : ""}
              href="#"
              onClick={(e) => {
                e.preventDefault();
                setPills("2");
              }}
            >
              <i className="now-ui-icons design_image"></i>
            </NavLink>
          </NavItem>
        )}
        {posts.length > 8 && (
          <NavItem>
            <NavLink
              className={pills === "3" ? "active" : ""}
              href="#"
              onClick={(e) => {
                e.preventDefault();
                setPills("3");
              }}
            >
              <i className="now-ui-icons design_image"></i>
            </NavLink>
          </NavItem>
        )}
      </Nav>
    </div>

    <TabContent className="gallery" activeTab={`pills${pills}`}>
      <TabPane tabId="pills1">
  <Row className="collections">
    {posts.length > 0 ? (
      posts.slice(0, 4).map((post, idx) => (
        <Col md="6" key={idx}>
          <img
  onClick={() => navigate(`/modifier-post/${post._id}`)}
  alt={post.description}
  className="img-raised"
  src={post.image ? `http://localhost:3001/${post.image}` : "/Profils/default.jpg"}
  style={{ width: "100%", height: "auto", cursor: "pointer" }}
/>
          <p className="text-center">{post.description}</p>
        </Col>
      ))
    ) : (
      <Col className="text-center" md="12">
         <br/>
         <div className="button-container">
            <p><strong>Il n'y a pas encore de posts.</strong></p>
              <Button  onClick={() => navigate("/ajouter-post")} className="btn-round" color="info" size="lg">
                Ajouter un post 
              </Button>
              </div>
      </Col>
    )}
  </Row>
</TabPane>


      {posts.length > 4 && (
        <TabPane tabId="pills2">
          <Row className="collections">
            {posts.slice(4, 8).map((post, idx) => (
              <Col md="6" key={idx}>
               <img
  onClick={() => navigate(`/modifier-post/${post._id}`)}
  alt={post.description}
  className="img-raised"
  src={post.image ? `http://localhost:3001/${post.image}` : "/Profils/default.jpg"}
  style={{ width: "100%", height: "auto", cursor: "pointer" }}
/>
                <p className="text-center">{post.description}</p>
              </Col>
            ))}
          </Row>
        </TabPane>
      )}

      {posts.length > 8 && (
        <TabPane tabId="pills3">
          <Row className="collections">
            {posts.slice(8, 12).map((post, idx) => (
              <Col md="6" key={idx}>
                <img
  onClick={() => navigate(`/modifier-post/${post._id}`)}
  alt={post.description}
  className="img-raised"
  src={post.image ? `http://localhost:3001/${post.image}` : "/Profils/default.jpg"}
  style={{ width: "100%", height: "auto", cursor: "pointer" }}
/>
                <p className="text-center">{post.description}</p>
              </Col>
            ))}
          </Row>
        </TabPane>
      )}
    </TabContent>
  </Col>
</Row>

            </>
             )}
          </Container>
        </div>
        <DefaultFooter />
      </div>
    </>
  );
}

export default ProfilePage;
