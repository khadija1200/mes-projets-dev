import React, { useEffect, useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import {
  Button, Container, Row, Col, Form, Input, Label, FormGroup
} from "reactstrap";
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import ProfilePageHeader from "components/Headers/ProfilePageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function ModifierProfil() {
  const [userData, setUserData] = useState({});
  const [user, setUser] = useState({});
  const [prestataire, setPrestataire] = useState({});
  const [photoFile, setPhotoFile] = useState(null);
  const navigate = useNavigate();
   
      
   const [role, setRole] = useState(() => localStorage.getItem("role"));
   const [userId, setUserId] = useState(() => localStorage.getItem("userId"));

  useEffect(() => {
   const userId = localStorage.getItem("userId");
    if (userId) {
      axios.get(`http://localhost:3001/api/user/${userId}`)
        .then((res) => {
          setUserData(res.data);
          setUser(res.data.user || {});
          setPrestataire(res.data.prestataire || {});
        })
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

  const handleUserChange = (e) => {
    setUser(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handlePrestataireChange = (e) => {
    setPrestataire(prev => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handlePhotoChange = (e) => {
    setPhotoFile(e.target.files[0]);
  };

 const handleSubmit = async (e) => {
  e.preventDefault();
  const userId = localStorage.getItem("userId");
  const formData = new FormData();

  // ✅ Ajouter l'objet user en JSON
  formData.append("user", JSON.stringify(user));

  // ✅ Ajouter l'objet prestataire si pro
  if (userData.user?.role === "professionnel") {
    formData.append("prestataire", JSON.stringify(prestataire));
  }

  // ✅ Ajouter l’image si sélectionnée
  if (photoFile) {
    formData.append("profil", photoFile); // ce nom doit correspondre à upload.single("profil")
  }

  try {
    await axios.put(`http://localhost:3001/api/user/${userId}`, formData, {
      headers: { "Content-Type": "multipart/form-data" }
    });
    navigate("/profile-page");
  } catch (err) {
    console.error(err);
  }
};

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
            <h3>Modifier mon profil</h3>
            <Form onSubmit={handleSubmit} encType="multipart/form-data">
              <FormGroup>
                <Label>Nom</Label>
                <Input type="text" name="nom" value={user.nom || ""} onChange={handleUserChange} />
              </FormGroup>
              <FormGroup>
                <Label>Prénom</Label>
                <Input type="text" name="prenom" value={user.prenom || ""} onChange={handleUserChange} />
              </FormGroup>
              <FormGroup>
                <Label>Email</Label>
                <Input type="email" name="email" value={user.email || ""} onChange={handleUserChange} />
              </FormGroup>
              <FormGroup>
                <Label>Téléphone</Label>
                <Input type="text" name="telephone" value={user.telephone || ""} onChange={handleUserChange} />
              </FormGroup>
               <Label  >Photo de profil</Label>
              <FormGroup>
                <Label  >Photo de profil</Label>
                <Input style={{ opacity: 1 }} type="file" name="profil" onChange={handlePhotoChange} />
              </FormGroup>
              <FormGroup>
                <Label>Date de naissance</Label>
                <Input type="date" name="dateNaissance" value={user.dateNaissance?.substring(0, 10) || ""} onChange={handleUserChange} />
              </FormGroup>
              <FormGroup>
                <Label>Genre</Label>
                <Input type="select" name="genre" value={user.genre || ""} onChange={handleUserChange}>
                  <option value="">-- Sélectionner --</option>
                  <option value="Femme">Femme</option>
                  <option value="Homme">Homme</option>
                </Input>
              </FormGroup>

              {user.role === "professionnel" && (
                <>
                  <hr />
                  <h4>Informations professionnelles</h4>
                  <FormGroup>
                    <Label>Spécialité</Label>
                    <Input type="text" name="specialite" value={prestataire.specialite || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Adresse</Label>
                    <Input type="text" name="adresse" value={prestataire.adresse || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Ville</Label>
                    <Input type="text" name="ville" value={prestataire.ville || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Code postal</Label>
                    <Input type="text" name="codePostal" value={prestataire.codePostal || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Pays</Label>
                    <Input type="text" name="pays" value={prestataire.pays || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Description</Label>
                    <Input type="textarea" name="description" value={prestataire.description || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Description 2</Label>
                    <Input type="textarea" name="description2" value={prestataire.description2 || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Tarif horaire (€)</Label>
                    <Input type="number" name="tarifHoraire" value={prestataire.tarifHoraire || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Disponibilité</Label>
                    <Input type="text" name="disponibilite" value={prestataire.disponibilite || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                  <FormGroup>
                    <Label>Site Web</Label>
                    <Input type="text" name="siteWeb" value={prestataire.siteWeb || ""} onChange={handlePrestataireChange} />
                  </FormGroup>
                </>
              )}

              <Button color="info" type="submit">Enregistrer</Button>
            </Form>
          </Container>
        </div>
        <DefaultFooter />
      </div>
    </>
  );
}

export default ModifierProfil;
