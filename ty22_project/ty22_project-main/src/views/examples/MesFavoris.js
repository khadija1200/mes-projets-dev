import React, { useEffect, useState } from "react";
import axios from "axios";
import PrestataireCard from "../index-sections/PrestataireCard.js";
import { useNavigate } from "react-router-dom";
import {
  Button, Container
} from "reactstrap";
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import ProfilePageHeader from "components/Headers/ProfilePageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function MesFavoris() {
    const [userData, setUserData] = useState({});
      const [user, setUser] = useState({});
  const navigate = useNavigate();
   const [favoris, setFavoris] = useState([]);
  const [userId, setUserId] = useState(() => localStorage.getItem("userId"));
  const [role, setRole] = useState(() => localStorage.getItem("role"));

  useEffect(() => {
     const userId = localStorage.getItem("userId");
    if (userId) {
      axios.get(`http://localhost:3001/api/user/${userId}`)
        .then((res) => {
          setUserData(res.data);
          setUser(res.data.user || {});
        })
        .catch((err) => console.error(err));
    }

    axios.get(`http://localhost:3001/api/favoris/${userId}`)
      .then(res => setFavoris(res.data))
      .catch(err => console.error(err));

    document.body.classList.add("profile-page");
    document.body.classList.add("sidebar-collapse");
    document.documentElement.classList.remove("nav-open");
    window.scrollTo(0, 0);
    document.body.scrollTop = 0;
    return function cleanup() {
      document.body.classList.remove("profile-page");
      document.body.classList.remove("sidebar-collapse");
    };
  }, [userId]);



  const handleLogout = () => {
  setUserId(null);
  setRole(null);
  localStorage.removeItem("userId");
  localStorage.removeItem("role");
  localStorage.removeItem("token"); 
   navigate("/index")
};

  if (!userData.user) return <p>Chargement...</p>;

  return (
    <>
      <ExamplesNavbar userId={userId} role={role} onLogout={handleLogout} />
      <div className="wrapper">
  <ProfilePageHeader user={user} />
  <div className="section">
    <Container style={{ paddingTop: "100px" }}>
      <div className="main">
        {favoris.length === 0 ? (
          <p>Vous n'avez encore ajouté aucun professionnel.</p>
        ) : (
          <div
            style={{
              display: "flex",
              flexDirection: "column",
              alignItems: "center",
              marginTop: "5%",
              gap: "20px",
            }}
          >
            {favoris.map((prest, idx) => (
              <PrestataireCard
                key={idx}
                id={prest._id}
                nom={prest.nom}
                prenom={prest.prenom}
                profil={`http://localhost:3001/${prest.profil}`}
                description={prest.description}
              />
            ))}
          </div>
        )}
      </div>
    </Container>
  </div>
  <DefaultFooter />
</div>

    </>
  );
}

export default MesFavoris;
