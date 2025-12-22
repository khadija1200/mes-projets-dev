import React from "react";

import ReactDOM from "react-dom";

import { BrowserRouter, Route, Routes, Navigate } from "react-router-dom";
 
import "assets/css/bootstrap.min.css";

import "assets/scss/now-ui-kit.scss?v=1.5.0";

import "assets/demo/demo.css?v=1.5.0";

import "assets/demo/nucleo-icons-page-styles.css?v=1.5.0";
 
import Index from "views/Index.js";

import NucleoIcons from "views/NucleoIcons.js";

import LoginPage from "views/examples/LoginPage.js";
import ModifierProfil from "views/examples/ModifierProfil.js";
import ModifierPost from "views/examples/ModifierPost.js";
import AjouterPost from "views/examples/AjouterPost.js";
import LandingPage from "views/examples/LandingPage.js";
import MesFavoris from "views/examples/MesFavoris.js";

import ProfilePage from "views/examples/ProfilePage.js";
import SignupPage from "views/examples/SignupPage";
 
ReactDOM.render(
<BrowserRouter>
<Routes>
<Route path="/index" element={<Index />} />
<Route path="/nucleo-icons" element={<NucleoIcons />} />
<Route path="/profilPrestataire/:id" element={<LandingPage />} />
<Route path="/profile-page" element={<ProfilePage />} />
<Route path="/modifier-profil" element={<ModifierProfil />} />
<Route path="/modifier-post/:id" element={<ModifierPost />} />
<Route path="/ajouter-post" element={<AjouterPost />} />
<Route path="/login" element={<LoginPage />} />
<Route path="/signup" element={<SignupPage />} />
<Route path="/mes-favoris" element={<MesFavoris />} />
<Route path="*" element={<Navigate to="/index" replace />} />
</Routes>
</BrowserRouter>,

  document.getElementById("root")

);

 