package com.example.demo.model;

import jakarta.persistence.*;
import lombok.Data;

@Data
@Entity
public class Candidature {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String poste;

    @Column(length = 2000)
    private String message;

    private String cvUrl;

    @Enumerated(EnumType.STRING)
    private CandidatureStatus status = CandidatureStatus.EN_ATTENTE;

    @ManyToOne
    private User candidat;

    @ManyToOne
    private Recruiter recruiter;
}