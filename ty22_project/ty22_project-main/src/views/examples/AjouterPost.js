import React, { useEffect, useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import {
  Button, Container, Row, Col, Form, Input, Label, FormGroup
} from "reactstrap";
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import ProfilePageHeader from "components/Headers/ProfilePageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function AjouterPost() {
    const [userData, setUserData] = useState({});
      const [user, setUser] = useState({});
const [image, setImage] = useState(null);
  const [description, setDescription] = useState("");
  const navigate = useNavigate();
 
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

 const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append("image", image);
    formData.append("description", description);
    formData.append("userId", userId);

    try {
      await axios.post("http://localhost:3001/api/posts", formData, {
        headers: { "Content-Type": "multipart/form-data" }
      });
      navigate("/profile-page"); // ou une autre page
    } catch (error) {
      console.error("Erreur lors de l'ajout :", error);
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
            <h3>Ajouter un post</h3>
            <Form onSubmit={handleSubmit} encType="multipart/form-data">
              <FormGroup>
                <Label>Description</Label>
                <Input type="textarea" name="nom" value={description} onChange={(e) => setDescription(e.target.value)}
            required />
              </FormGroup>
               <Label>Image</Label>
              <FormGroup>
                <Label>Image</Label>
              < Input
            type="file"
            accept="image/*"
            onChange={(e) => setImage(e.target.files[0])}
            style={{ opacity: 1 }}
            required
          />
              </FormGroup>
              

              <Button color="info" type="submit">Ajouter</Button>
            </Form>
          </Container>
        </div>
        <DefaultFooter />
      </div>
    </>
  );
}

export default AjouterPost;
