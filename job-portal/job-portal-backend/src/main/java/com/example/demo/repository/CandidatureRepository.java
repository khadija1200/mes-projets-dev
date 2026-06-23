package com.example.demo.repository;

import com.example.demo.model.Candidature;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface CandidatureRepository extends JpaRepository<Candidature, Long> {

    List<Candidature> findByRecruiterId(Long recruiterId);

    List<Candidature> findByCandidatId(Long candidatId);
}