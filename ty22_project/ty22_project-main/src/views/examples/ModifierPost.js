import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import {
  Button, Container, Row, Col, Form, Input, Label, FormGroup,Modal, ModalBody
} from "reactstrap";
import ExamplesNavbar from "components/Navbars/ExamplesNavbar.js";
import ProfilePageHeader from "components/Headers/ProfilePageHeader.js";
import DefaultFooter from "components/Footers/DefaultFooter.js";

function ModifierPost() {
    const [modalOpen, setModalOpen] = useState(false);
    const { id } = useParams();
    const [userData, setUserData] = useState({});
      const [user, setUser] = useState({});
const navigate = useNavigate();
  const [post, setPost] = useState({ description: "", image: "" });
  const [imageFile, setImageFile] = useState(null);

   const [role, setRole] = useState(() => localStorage.getItem("role"));
   const [userId, setUserId] = useState(() => localStorage.getItem("userId"));
  
  

  useEffect(() => {
    console.log("ID du post à modifier :", id); // 👈 vérifie qu'il affiche bien l'id attendu
      const userId = localStorage.getItem("userId");
    if (userId) {
      axios.get(`http://localhost:3001/api/user/${userId}`)
        .then((res) => {
          setUserData(res.data);
          setUser(res.data.user || {});
        })
        .catch((err) => console.error(err));


        axios.get(`http://localhost:3001/api/post/${id}`)
      .then((res) => setPost(res.data))
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
 const handleChange = (e) => {
    setPost({ ...post, [e.target.name]: e.target.value });
  };

  const handleFileChange = (e) => {
    setImageFile(e.target.files[0]);
  };

 const handleSubmit = async (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append("description", post.description);
    if (imageFile) formData.append("image", imageFile);

    try {
      await axios.put(`http://localhost:3001/api/post/${id}`, formData, {
        headers: { "Content-Type": "multipart/form-data" },
      });
      navigate("/profile-page"); // ou une autre page
    } catch (err) {
      console.error(err);
    }
  };
  const handleDelete = async () => {
  try {
    await axios.delete(`http://localhost:3001/api/post/${id}`);
    setModalOpen(false);
    navigate("/profile-page"); // redirige après suppression
  } catch (err) {
    console.error("Erreur lors de la suppression :", err);
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
      <ExamplesNavbar userId={userId} role={role} onLogout={handleLogout}  />
      <div className="wrapper">
        <ProfilePageHeader user={user} />
        <div className="section">
          <Container style={{ paddingTop: "100px" }}>
            <h3>Modifier le post</h3>
            <Form onSubmit={handleSubmit} encType="multipart/form-data">
              <FormGroup>
                <Label>Description</Label>
                <Input type="textarea" name="description" value={post.description} onChange={handleChange}
            required />
              </FormGroup>
               <Label>Image</Label>
              <FormGroup>
                <Label>Image</Label>
              < Input
            type="file"
            accept="image/*"
           onChange={handleFileChange}
            style={{ opacity: 1 }}
          
            
          />
              </FormGroup>
              

              <Button color="info" type="submit">Enregistrer</Button>
              <Button color="danger" onClick={() => setModalOpen(true)}>
                  Supprimer ce post
             </Button>
            </Form>
          </Container>
        </div>
        <DefaultFooter />
      </div>
      <Modal isOpen={modalOpen} toggle={() => setModalOpen(false)}>
  <div className="modal-header justify-content-center">
    <button
      className="close"
      type="button"
      onClick={() => setModalOpen(false)}
    >
      <i className="now-ui-icons ui-1_simple-remove"></i>
    </button>
    <h4 className="title title-up">Confirmation</h4>
  </div>
  <ModalBody>
    <p>Es-tu sûr(e) de vouloir supprimer ce post ?</p>
  </ModalBody>
  <div className="modal-footer">
    <Button color="danger" onClick={handleDelete}>
      Supprimer
    </Button>
    <Button color="secondary" onClick={() => setModalOpen(false)}>
      Annuler
    </Button>
  </div>
</Modal>

    </>
  );
}

export default ModifierPost;
